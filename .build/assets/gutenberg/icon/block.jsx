const { _x, __ } = wp.i18n;
const ServerSideRender = wp.serverSideRender;
const { registerBlockType } = wp.blocks;
const { apiFetch } = wp;
const { registerStore, withSelect } = wp.data;
const { Spinner, PanelBody, PanelRow, RadioControl, TextControl } = wp.components;
const { InspectorControls, PanelColorSettings, BlockControls, AlignmentToolbar, BlockAlignmentToolbar } = wp.blockEditor;
const { withState } = wp.compose;

import icon from './icon.jsx';

/**
 * Register secure block
 */
export default registerBlockType(
	'shp-icon/icon', {
		title: _x( 'SVG Icon', 'SVG Icon Block Title', 'shp-icon' ),
		description: __( 'Use your SVG Icons as Gutenberg Block', 'shp-icon' ),
		icon: icon,
		category: 'embed',
		keywords: [
			__( 'Icons' ),
			__( 'SVG' ),
		],
		supports: {
			align: true,
		},
		attributes: {
			icon: {
				type: 'string',
				default: null,
			},
			boxModel: {
				type: 'string',
				default: 'block',
			},
			scaleFactor: {
				type: 'number',
				default: parseFloat( shp_icon_data.scaleFactor )
			},
			topShift: {
				type: 'number',
				default: parseFloat( shp_icon_data.topShift )
			},
			color: {
				type: 'string',
				default: 'inherit',
			},
			backgroundColor: {
				type: 'string',
				default: 'transparent',
			},
			align: {
				type: 'string',
				default: 'normal',
			}
		},
		edit: withSelect( ( select ) => {
			return {
				iconList: select( 'shp-icon/icon-list' ).recieveIcons(),
			};
		} )( props => {
			const { attributes: { icon, boxModel, scaleFactor, topShift, color, backgroundColor, verticalAlignment }, attributes, iconList, className, setAttributes } = props;

			if ( !iconList.length ) {
				return (
					<div className="components-placeholder">
						<div className="components-placeholder__fieldset">
							<div className="components-spinner"></div>
						</div>
					</div>
				);
			}

			return [
				<BlockControls>
					{/* <AlignmentToolbar
						onChange={ ( alignment ) => { console.log(alignment); } }
						value={ '' }
					/> */}
					{/* <BlockAlignmentToolbar
						onChange={ ( verticalAlignment ) => { setAttributes( { verticalAlignment } ); console.log(verticalAlignment); } }
						value={ verticalAlignment }
					/> */}
				</BlockControls>,
				<InspectorControls className="shp-icon-controls">
					<PanelBody title={_x( 'Icon Collection', 'SVG Icon Block Panel Title', 'shp-icon' )} initialOpen={true}>
						<div className="shp-icon-controls__icon-list">
							<RadioControl
								selected={ icon }
								options={ iconList.map(function (icon) { return { label: <i className="shp-icon" dangerouslySetInnerHTML={{ __html: icon.svg }}></i> , value: icon.filename} }) }
								onChange={ ( icon ) => { setAttributes( { icon } ) } }
							/>
						</div>
					</PanelBody>
					{/* <PanelBody title={_x( 'Settings', 'SVG Icon Block Panel Title', 'shp-icon' )} initialOpen={true}>
						<RadioControl
							label={_x( 'Choose Icon Box-Model', 'SVG Icon Block RadioControl Label', 'shp-icon' )}
							help={_x( 'Inline fits to font-size of the parent element, Block uses the full available space.', 'SVG Icon Block RadioControl Label', 'shp-icon' )}
							selected={ boxModel }
							options={ [
						{ label: 'Inline', value: 'inline' },
						{ label: 'Block', value: 'block' },
							] }
							onChange={ ( boxModel ) => { setAttributes( { boxModel } ) } }
						/>
						{ boxModel === 'inline' &&
							<TextControl
						label={_x( 'Scale Factor', 'SVG Icon Block TextControl Label', 'shp-icon' )}
						type={'number'}
						value={ scaleFactor }
						onChange={ ( scaleFactor ) => { setAttributes( { scaleFactor } ) } }
							/>
						}
						{ boxModel === 'inline' &&
							<TextControl
						label={_x( 'Top Shift', 'SVG Icon Block TextControl Label', 'shp-icon' )}
						type={ 'number' }
						step={ 0.01 }
						value={ topShift }
						onChange={ ( topShift ) => { setAttributes( { topShift } ) } }
							/>
						}
					</PanelBody> */}
					<PanelColorSettings
						title={ _x( 'Color Settings', 'SVG Icon Block PanelColorSettings Label', 'shp-icon' ) }
						colorSettings={[{
							value: color,
							onChange: ( color ) => { if (typeof color !== "undefined") { setAttributes( { color } )} else {setAttributes( { color: 'inherit' } ) }; },
							label: _x( 'Color', 'SVG Icon Block colorSettings abel', 'shp-icon' ),

						},{
							value: backgroundColor,
							onChange: ( backgroundColor ) => { if (typeof backgroundColor !== "undefined") { setAttributes( { backgroundColor } )} else {setAttributes( { backgroundColor: 'transparent' } ) }; },
							label: _x( 'Background Color', 'SVG Icon Block colorSettings label', 'shp-icon' ),
						}]}
					>
						<i>{ _x( 'The color feature only works with SVG’s using currentColor.', 'SVG Icon Block colorSettings notice', 'shp-icon' ) }</i>
					</PanelColorSettings>
				</InspectorControls>,
				<ServerSideRender block="shp-icon/icon" attributes={attributes}/>
			];
		} ),
		save: props => {
			return null;
		},
	},
);

const actions = {
	setIcons( icons ) {
		return {
			type: 'SET_ICONS',
			icons,
		};
	},
	recieveIcons( path ) {
		return {
			type: 'RECIEVE_ICONS',
			path,
		};
	},
};

const store = registerStore( 'shp-icon/icon-list', {
	reducer( state = { icons: {} }, action ) {

		switch ( action.type ) {
		case 'SET_ICONS':
			return {
				...state,
				icons: action.icons,
			};
		}

		return state;
	},

	actions,

	selectors: {
		recieveIcons( state ) {
			const { icons } = state;
			return icons;
		},
	},

	controls: {
		RECIEVE_ICONS( action ) {
			return apiFetch( { path: action.path } );
		},
	},

	resolvers: {
		* recieveIcons( state ) {
			const icons = yield actions.recieveIcons( '/shp-icon/v1/icons/' );
			return actions.setIcons( icons );
		},
	},
} );