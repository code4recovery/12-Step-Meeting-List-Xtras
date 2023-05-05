/**
 * useBlockProps is a React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 *
 * RichText is a component that allows developers to render a contenteditable input,
 * providing users with the option to format block content to make it bold, italics,
 * linked, or use other formatting.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/richtext/
 */
import { InspectorControls, useBlockProps, AlignmentToolbar, BlockControls, BlockIcon } from '@wordpress/block-editor';
import { TextControl, Panel, PanelBody, SelectControl, CheckboxControl, Placeholder } from "@wordpress/components";
import { __ } from '@wordpress/i18n';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
// import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object}   param0
 * @param {Object}   param0.attributes
 * @param {string}   param0.attributes.message
 * @param {Function} param0.setAttributes
 * @return {WPElement} Element to render.
 */
const Edit = ( props ) => {
    const {
        attributes: { blocktype },
        setAttributes
    } = props;

    const { serverSideRender: ServerSideRender } = wp;
    return (
        <div { ...useBlockProps() }>
            <InspectorControls>
                <Panel>
                    <PanelBody
                        title={ __( 'Block Settings', 'tsmlxtras-meetings-block' ) }
                        icon="admin-plugins"
                    >
                        <SelectControl
                            label="Select Block Type"
                            value={props.attributes.blockType}
                            options={[
                                { label: 'Meetings UI', value: 'tsml_ui' },
                                { label: 'Next Meetings', value: 'tsml_next_meetings' },
                                { label: 'Types List', value: 'tsml_types_list' },
                                { label: 'Regions List', value: 'tsmlx_get_regions_list' },
                                { label: 'Xtras Meeing Table', value: 'tsmlx' },
                            ]}
                            onChange={(newtype) => setAttributes({ blockType: newtype })}
                        />
                        <CheckboxControl
                            label="Show Count of Meetings (where applicable)"
                            checked={props.attributes.showCount}
                            onChange={(newShowCount) => setAttributes({ showCount: newShowCount })}
                        />
                    </PanelBody>
                </Panel>
            </InspectorControls>
            {(props.attributes.blockType == 'tsml_ui') && (
                <Placeholder
                    icon={<BlockIcon icon="groups" size="50" />}
                    label={__("12 Step Meeting List Xtras blocks", "tsmlxtras-meetings-block")}
                    instructions={__("Some blocks will not render in the editor. View the page to see the block.", "tsmlxtras-meetings-block")}>
                </Placeholder>
            )}
            <ServerSideRender
                block="tsmlxtras/meetings-block"
                attributes={ props.attributes }
            />
        </div>
    );
};
export default Edit;
