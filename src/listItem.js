/**
 * This file contains the extensions for core/list-item.
 *
 * @package nested-ordered-lists-block-editor
 */

/**
 * Import language-support.
 */
const { __ } = wp.i18n;

/**
 * Set more imports and constants.
 */
import classnames from 'classnames';
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const {	InspectorControls } = wp.blockEditor;
const { Button, PanelBody } = wp.components;
import {IconPicker} from "wordpress-icon-picker";
import { enableSidebarSelectOnBlocks } from './helper';

/**
 * Add our custom list-item-attributes to the items for this block.
 */
const addListItemAttributes = ( settings, name ) => {
	// Do nothing if it's another block than our defined ones.
	if ( 'core/list-item' !== name ) {
		return settings;
	}

	// add new attributes.
	settings.attributes = Object.assign(settings.attributes, {
		icon: { type: 'string', default: undefined },
	});

	// return resulting settings for this list item.
	return settings;
};
wp.hooks.addFilter(
	'blocks.registerBlockType',
	'nolg/add-list-item-attributes',
	addListItemAttributes
);

/**
 * Add options on list item.
 *
 * Used for icon picker: https://github.com/jamilbd07/WordPress-Icon-Picker
 */
const addOptionsToListItemBlock = createHigherOrderComponent( ( BlockEdit ) => {
	return (props) => {
		// If current block is not allowed.
		if ( 'core/list-item' !== props.name ) {
			return (
				<BlockEdit {...props} />
			);
		}

		// get parent settings for nested list, if available and enabled on parent.
		const parentBlocks = wp.data.select( 'core/block-editor' ).getBlockParentsByBlockName(props.clientId, enableSidebarSelectOnBlocks, false );
		const parentAttributes = wp.data.select('core/block-editor').getBlocksByClientId(parentBlocks);

		// bail if no parent could be found (should be an error in structure of editor).
		if( ! parentAttributes || parentAttributes.length === 0 ) {
			return (
				<BlockEdit {...props} />
			);
		}

		// get the icon type.
		let dashicons = ['dashicons'].includes(parentAttributes[0].attributes.type);
		let fontawesome = ['fontawesome'].includes(parentAttributes[0].attributes.type);

		// bail if both types are false.
		if( ! dashicons && ! fontawesome ) {
			return (
				<BlockEdit {...props} />
			);
		}

		// get attributes.
		const { attributes, setAttributes } = props;
		attributes.clientId = props.clientId;

		/**
		 * Set the icon for this item.
		 *
		 * @param value
		 */
		const onClickSetIcon = ( value ) => {
			setAttributes({
				icon: value,
			});
		}

		/**
		 * Remove the icon from this item.
		 */
		const onClickRemoveIcon = () => {
			setAttributes({
				icon: undefined,
			});
		}

		// create output.
		return (
			<Fragment>
				<BlockEdit { ...props } />
				{parentAttributes[0].attributes.ordered && <InspectorControls>
					<PanelBody
						title={ __( 'Advanced List Item Controls', 'nested-ordered-lists-for-block-editor' ) }
					>
						<IconPicker
							value={attributes.icon}
							onChange={(value) =>
								onClickSetIcon(value)
							}
							title={ __( 'Select Icon', 'nested-ordered-lists-for-block-editor' ) }
							showHeading={false}
							disableDashicon={!dashicons}
							disableFontAwesome={!fontawesome}
						/>
						<Button disabled={!attributes.icon} variant="secondary" onClick={ (value) => onClickRemoveIcon() } text={ __( 'Remove the chosen icon', 'nested-ordered-lists-for-block-editor' ) }></Button>
					</PanelBody>
				</InspectorControls>
				}
			</Fragment>
		);
	}
});
wp.hooks.addFilter(
	'editor.BlockEdit',
	'nolg/add-option-on-list-item',
	addOptionsToListItemBlock
);

/**
 * Define additional block-elements for output in Block Editor.
 */
function setAttributesOnListItemInEditor( BlockListBlock ) {
	return ( props ) => {
		// bail if current block is not list-item.
		if ( 'core/list-item' !== props.name ) {
			return <BlockListBlock { ...props } />;
		}

		// bail if no icon is set.
		if( props.attributes.icon === undefined ) {
			return <BlockListBlock { ...props } />;
		}

		// get the class name depending on used iconset.
		let classNames = 'nolg-iconset dashicons ' + props.attributes.icon;
		if( props.attributes.icon.includes( 'fab' ) ) {
			classNames = 'nolg-iconset fa ' + props.attributes.icon;
		}

		// add our classes to the output and return the resulting properties.
		return <BlockListBlock { ...props } className={ classNames } />
	};
}
wp.hooks.addFilter(
	'editor.BlockListBlock',
	'nolg/set-attributes-on-list-item-in-editor',
	setAttributesOnListItemInEditor
);

/**
 * Save custom attribute for output of list item in frontend.
 */
const saveAttributesForListItemInFrontend = ( extraProps, blockType, attributes ) => {
	// bail if it's another block than list-item.
	if ( 'core/list-item' !== blockType.name ) {
		return extraProps;
	}

	// bail if no icon is set.
	if( attributes.icon === undefined ) {
		return extraProps;
	}

	// get the class name depending on used iconset.
	let classNames = 'nolg-iconset dashicons ' + attributes.icon;
	if( attributes.icon.includes( 'fab' ) ) {
		classNames = 'nolg-iconset fa ' + attributes.icon;
	}

	// add our own class.
	extraProps.className = classnames( extraProps.className, classNames );

	// return the resulting properties.
	return extraProps;
};
wp.hooks.addFilter(
	'blocks.getSaveContent.extraProps',
	'nolg/save-attributes-for-list-item-in-frontend',
	saveAttributesForListItemInFrontend
);
