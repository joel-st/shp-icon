import gulp from 'gulp';

import gulpWebpack from 'webpack-stream';
import livereload from 'gulp-livereload';
import rename from 'gulp-rename';
import uglify from 'gulp-uglify';
import fs from 'fs';

import babelloader from 'babel-loader';

function getDirectories(path) {
	return fs.readdirSync(path).filter(function (file) {
		return fs.statSync(path + '/' + file).isDirectory();
	});
}

const wplib = [
	'i18n',
];

export const task = config => {
	return new Promise(resolve => {
		const bundles = getDirectories(`${config.assetsBuild}scripts/`);
		const entry = {};
		bundles.forEach(bundle => {
			const filePath = `${config.assetsBuild}scripts/${bundle}/index.js`;
			if(fs.existsSync(filePath)) {
				entry[bundle] = './' + filePath;
			}
		});

		gulp.src([
				`${config.assetsBuild}scripts/*`
			])
			// Webpack
			.pipe(
				gulpWebpack({
					entry,
					mode: 'production',
					module: {
						rules: [{
							test: /\.js$/,
							exclude: /node_modules/,
							loader: "babel-loader"
						}]
					},
					output: {
						filename: '[name].js',
						library: ['wp', 'i18n'],
						libraryTarget: 'window'
					},
					externals: {
						"jquery": "jQuery"
					},
					optimization: {
						minimize: false //Update this to true or false
					},
					externals: wplib.reduce((externals, lib) => {
						externals[`wp.${lib}`] = {
							window: ['wp', lib],
						};
						return externals;
					}, {}),
				})
			)
			.on('error', config.errorLog)
			.pipe(gulp.dest(config.assetsDir + 'scripts/'))

			// Minify
			.pipe(uglify())
			.pipe(rename({
				suffix: '.min'
			}))
			.on('error', config.errorLog)
			.pipe(gulp.dest(config.assetsDir + 'scripts/'))

			//reload
			.pipe(livereload());
		resolve();
	});
};