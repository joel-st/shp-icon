import gulp from 'gulp';

import wpPot from 'gulp-wp-pot';

export const task = config => {
	return gulp.src(['*.php', '**/*.php', '**/*.twig', 'assets/*.js'])
		.pipe(wpPot({
			domain: config.key,
			package: config.name
		}))
		.pipe(gulp.dest(`languages/${config.key}.pot`));
};