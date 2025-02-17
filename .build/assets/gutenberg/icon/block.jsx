import { __, _x } from "@wordpress/i18n";
import ServerSideRender from "@wordpress/server-side-render";
import { registerBlockType } from "@wordpress/blocks";
import { useSelect } from "@wordpress/data";
import { PanelBody, RadioControl, Spinner } from "@wordpress/components";
import { InspectorControls, PanelColorSettings } from "@wordpress/block-editor";
import { useState, useEffect } from "react"; // Import useState and useEffect

import icon from "./icon.jsx";

const blockName = "shp-icon/icon";

export default registerBlockType(blockName, {
    title: _x("SVG Icon", "SVG icon block title", "shp-icon"),
    description: __("Use your SVG icons as Gutenberg block", "shp-icon"),
    icon: icon,
    category: "embed",
    keywords: [__("Icons"), __("SVG")],
    supports: {
        align: false,
        anchor: true,
    },
    attributes: {
        icon: {
            type: "string",
            default: null,
        },
        color: {
            type: "string",
            default: "inherit",
        },
        backgroundColor: {
            type: "string",
            default: "transparent",
        },
        align: {
            type: "string",
            default: "normal",
        },
        anchor: {
            type: "string",
            default: "",
        },
    },
    edit: props => {
        const {
            attributes: { icon, color, backgroundColor },
            attributes,
            setAttributes,
        } = props;

        const [iconList, setIcons] = useState([]);

        //console.log('shp-icon', attributes)

        useEffect(() => {
            const fetchIcons = async () => {
                try {
                    const response = await fetch('/wp-json/shp-icon/v1/icons/');
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    const data = await response.json();
                    setIcons(data);
                } catch (err) {
                    console.error("Error fetching icons:", err);
                }
            };

            fetchIcons();
        }, []);

        if (!iconList.length) {
            return (
                <div className='components-placeholder'>
                    <div className='components-placeholder__fieldset'>
                        <Spinner />
                    </div>
                </div>
            );
        }

        let hasCurrentColor = false;
        if (icon) {
            const index = iconList.findIndex(x => x.filename === icon);
            if (
                -1 !== index &&
                -1 !==
                iconList[index]["svg"].toLowerCase().search("currentcolor")
            ) {
                hasCurrentColor = true;
            }
        }

        return [
            <InspectorControls className='shp-icon-controls'>
                <PanelBody
                    title={_x(
                        "Icon Collection",
                        "SVG icon block panel title",
                        "shp-icon"
                    )}
                    initialOpen={true}>
                    <div className='shp-icon-controls__icon-list'>
                        <RadioControl
                            selected={icon}
                            options={iconList.map(function (icon) {
                                return {
                                    label: (
                                        <i
                                            className='shp-icon'
                                            dangerouslySetInnerHTML={{
                                                __html: icon.svg,
                                            }}></i>
                                    ),
                                    value: icon.filename,
                                };
                            })}
                            onChange={icon => {
                                setAttributes({ icon });
                            }}
                        />
                    </div>
                </PanelBody>
                <PanelColorSettings
                    title={_x(
                        "Color Settings",
                        "SVG icon block PanelColorSettings label",
                        "shp-icon"
                    )}
                    colorSettings={[
                        {
                            value: color,
                            onChange: color => {
                                if (typeof color !== "undefined") {
                                    setAttributes({ color });
                                } else {
                                    setAttributes({ color: "inherit" });
                                }
                            },
                            label: _x(
                                "Color",
                                "SVG icon block colorSettings label",
                                "shp-icon"
                            ),
                        },
                        {
                            value: backgroundColor,
                            onChange: backgroundColor => {
                                if (typeof backgroundColor !== "undefined") {
                                    setAttributes({ backgroundColor });
                                } else {
                                    setAttributes({
                                        backgroundColor: "transparent",
                                    });
                                }
                            },
                            label: _x(
                                "Background Color",
                                "SVG icon block colorSettings label",
                                "shp-icon"
                            ),
                        },
                    ]}>
                    {!hasCurrentColor && (
                        <i style={{ color: "red" }}>
                            {_x(
                                "The color feature only works with SVG’s using currentColor. No currentColor value found in the selected SVG.",
                                "SVG icon block colorSettings notice",
                                "shp-icon"
                            )}
                        </i>
                    )}
                </PanelColorSettings>
            </InspectorControls>,
            <ServerSideRender block={blockName} attributes={attributes} />,
        ];
    },
});
