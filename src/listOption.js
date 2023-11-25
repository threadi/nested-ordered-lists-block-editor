/**
 * Import language-support.
 */
const { __ } = wp.i18n;

/**
 * Define which blocks will be changed by the following functions.
 * Only core/list will be changed.
 *
 * @type {string[]}
 */
const enableSidebarSelectOnBlocks = [
    'core/list'
];

/**
 * Set more imports and constants.
 */
import classnames from 'classnames';
import {
    __experimentalNumberControl as NumberControl,
} from '@wordpress/components';
const { createHigherOrderComponent } = wp.compose;
const { Fragment } = wp.element;
const {
    InspectorControls,
    BlockControls
} = wp.blockEditor;
const {
    ToolbarGroup,
    ToolbarButton,
    PanelBody,
    CheckboxControl
} = wp.components;
import { list_max_level } from './config';
import icons from './icons';

/**
 * Create the counter-reset-styling for the main OL depending on given attributes.
 *
 * @param props
 * @param attributes
 * @returns {{}}
 */
function getCounterReset( props, attributes ) {
    if( attributes.start !== undefined ) {
        let styleCounterReset = 'l1 ' + attributes.start;
        if (attributes.startlevel) {
            Object.keys(attributes.startlevel).forEach(function (i) {
                if (attributes.startlevel[i].active && attributes.startlevel[i].value > 0) {
                    styleCounterReset = styleCounterReset + ' l' + i + ' ' + attributes.startlevel[i].value;
                    props = {
                        ...props,
                        ['data-startl' + i]: attributes.startlevel[i].value,
                        ['data-typel' + i]: attributes.startlevel[i].type
                    }
                }
            });
        }
        props.style = {'counterReset': styleCounterReset};
    }

    // set list type
    props.type = "1";
    if( attributes.type ) {
        props.type = attributes.type;
    }

    // return result
    return props;
}

/**
 * Create array with all supported levels as attributes for the Block.
 * Starting with level 2 as level 1 is coming from original Block as "start".
 *
 * @param n
 * @returns {{}}
 */
function generateAttributeLevelArray(n) {
    let attributes = {};
    for(let i = 2; i < n; i++){
        Object.assign(attributes, {
            [i]: {
                'value': 0,
                'active': false
            }
        });
    }
    return attributes;
}

/**
 * Create elements for each supported level.
 *
 * @param n
 * @param object
 * @returns {*[]}
 */
function createElements(n, object){
    let elements = [];
    Object.keys(object.attributes.startlevel).forEach(function(i) {
        let title = '';
        if( !object.attributes.start ) {
            title = __('Set start level above first', 'nested-ordered-lists-for-block-editor');
        }

        // add checkbox to enable this level
        elements.push(
            <CheckboxControl key={[i] + 'checkbox'}
                             label={
                                sprintf(
                                    // translators: %d: number for level
                                    __('Use start level %d', 'nested-ordered-lists-for-block-editor'),
                                    i
                                )
                            }
                             checked={object.attributes.startlevel[i].active}
                             onChange={value => onChangeLevelAttributeActive( object, i, value )}
                             disabled={!object.attributes.start}
                             title={title}
            />
        );

        // add input-field for start-number
        elements.push(
            <NumberControl key={[i] + 'number'}
                           label={
                                sprintf(
                                    // translators: %d: number for level
                                    __('start value for level %d', 'nested-ordered-lists-for-block-editor'),
                                    i
                                )
                            }
                           labelPosition='top'
                           isShiftStepEnabled={true}
                           value={object.attributes.startlevel[i].value}
                           min={0}
                           disabled={!object.attributes.start}
                           title={title}
                           onChange={value => onChangeLevelAttributeValue( object, i, value )}
            />
        )
    });
    return elements;
}

/**
 * Update active-flag of given supported level.
 *
 * @param props
 * @param c
 * @param newValue
 */
export const onChangeLevelAttributeActive = ( props, c, newValue ) => {
    let newArray = {
        ...props.attributes.startlevel
    }
    Object.keys(newArray).forEach(function(i) {
        if( i === c ) {
            newArray[i].active = newValue
        }
    });
    props.setAttributes( { startlevel: newArray } );
}

/**
 * Update value of given supported level.
 *
 * @param props
 * @param c
 * @param newValue
 */
export const onChangeLevelAttributeValue = ( props, c, newValue ) => {
    let newArray = {
        ...props.attributes.startlevel
    }
    Object.keys(newArray).forEach(function(i) {
        if( i === c ) {
            newArray[i].value = parseInt(newValue)
        }
    });
    props.setAttributes( { startlevel: newArray } );
}

/**
 * Add our custom list-attributes to the list of allowed attributes for this block.
 */
const addListAttributes = ( settings, name ) => {
    // Do nothing if it's another block than our defined ones.
    if ( ! enableSidebarSelectOnBlocks.includes( name ) ) {
        return settings;
    }

    settings.attributes = Object.assign(settings.attributes, {
        nestedList: { type: 'boolean', default: false },
        listIntent: { type: 'boolean', default: false },
        inheritSettings: { type: 'boolean', default: true },
        type: { type: 'string', default: undefined },
        startlevel: { type: 'object', default: generateAttributeLevelArray(list_max_level) }
    });

    return settings;
};
wp.hooks.addFilter(
    'blocks.registerBlockType',
    'nolg/add-list-attributes',
    addListAttributes
);

/**
 * Define additional block-elements for output in Block Editor.
 */
const setAttributesInEditor = createHigherOrderComponent( ( BlockListBlock ) => {
    return ( props ) => {

        // If current block is not allowed
        if ( ! enableSidebarSelectOnBlocks.includes( props.name ) ) {
            return (
                <BlockListBlock { ...props } />
            );
        }

        /**
         * Get attributes
         */
        const { nestedList, listIntent } = props.attributes;

        // collect classes for list
        let nolgClassName = '';

        if( props.attributes.type ) {
            // set class name
            nolgClassName = nolgClassName + ' nolg-style';
        }

        /**
         * If nested list is activated for this Block add our own classes to it for styling.
         */
        if ( nestedList ) {
            // set class name
            nolgClassName = nolgClassName + ' nolg-list';

            // get counter-reset-styling
            let counterReset = getCounterReset({...props.wrapperProps}, props.attributes)

            if( listIntent ) {
                return <BlockListBlock { ...props } wrapperProps={counterReset} className={ nolgClassName + ' nolg-list-intent' } />
            }
            return <BlockListBlock { ...props } wrapperProps={counterReset} className={nolgClassName} />
        }

        return <BlockListBlock { ...props } className={nolgClassName} />
    };
}, 'withSidebarSelectProp' );
wp.hooks.addFilter(
    'editor.BlockListBlock',
    'nolg/set-attributes-in-editor',
    setAttributesInEditor
);

/**
 * Add our custom options in sidebar.
 */
const addOptionInSidebar = createHigherOrderComponent( ( BlockEdit ) => {
    return ( props ) => {

        // If current block is not allowed
        if ( ! enableSidebarSelectOnBlocks.includes( props.name ) ) {
            return (
                <BlockEdit { ...props } />
            );
        }

        // get attributes
        const { attributes, setAttributes } = props;
        let { nestedList, listIntent, inheritSettings } = attributes;

        // get parent settings for nested list, if available and enabled on parent
        const parentBlocks = wp.data.select( 'core/block-editor' ).getBlockParentsByBlockName(props.clientId, ['core/list']);
        const parentAttributes = wp.data.select('core/block-editor').getBlocksByClientId(parentBlocks);
        let inheritedSettings = false;
        if( parentAttributes[0] && parentAttributes[0].attributes.nestedList && parentAttributes[0].attributes.inheritSettings ) {
            inheritedSettings = true;
            attributes.ordered = parentAttributes[0].attributes.ordered;
            attributes.type = parentAttributes[0].type;
            nestedList = true;
        }

        /**
         * Update type of initial list.
         *
         * @param value
         */
        const onClickAttributeType = ( value ) => {
            {
                {
                    attributes.type !== value && setAttributes({
                        type: value,
                        ordered: true
                    });
                }
                {
                    attributes.type === value && setAttributes({
                        type: ''
                    });
                }
            }
        }

        // create output
        return (
            <Fragment>
                <BlockEdit { ...props } />
                {!inheritedSettings && <BlockControls group="block">
                        <ToolbarGroup>
                            <ToolbarButton
                                icon={ icons.lowerAlpha }
                                label={ __( 'lowercase letters style', 'nested-ordered-lists-for-block-editor' ) }
                                isActive={attributes.type === 'a1'}
                                onClick={ value => onClickAttributeType('a1') }
                            />
                            <ToolbarButton
                                icon= { icons.upperAlpha }
                                label={ __( 'uppercase letters style', 'nested-ordered-lists-for-block-editor' ) }
                                isActive={attributes.type === 'a2'}
                                onClick={ value => onClickAttributeType('a2') }
                            />
                            <ToolbarButton
                                icon={ icons.lowerRoman }
                                label={ __( 'lowercase roman style', 'nested-ordered-lists-for-block-editor' ) }
                                isActive={attributes.type === 'i1'}
                                onClick={ value => onClickAttributeType('i1') }
                            />
                            <ToolbarButton
                                icon={ icons.upperRoman }
                                label={ __( 'uppercase roman style', 'nested-ordered-lists-for-block-editor' ) }
                                isActive={attributes.type === 'i2'}
                                onClick={ value => onClickAttributeType('i2') }
                            />
                        </ToolbarGroup>
                    </BlockControls>
                }
                {attributes.ordered && !inheritedSettings && <InspectorControls>
                    <PanelBody
                        title={ __( 'Advanced List Controls', 'nested-ordered-lists-for-block-editor' ) }
                    >
                        <CheckboxControl
                            label={__('Use nested ordered lists', 'nested-ordered-lists-for-block-editor')}
                            checked={ nestedList }
                            onChange={ ( value ) => {
                                setAttributes( {
                                    nestedList: value,
                                } );
                            } }
                        />
                        <CheckboxControl
                            label={__('Inherit settings', 'nested-ordered-lists-for-block-editor')}
                            checked={ inheritSettings }
                            onChange={ ( value ) => {
                                setAttributes( {
                                    inheritSettings: value,
                                } );
                            } }
                        />
                        {nestedList &&
                            <CheckboxControl
                                label={__('with indentation', 'nested-ordered-lists-for-block-editor')}
                                checked={listIntent}
                                onChange={(value) => {
                                    setAttributes({
                                        listIntent: value,
                                    });
                                }}
                            />
                        }
                        {nestedList && createElements(list_max_level, props)}
                    </PanelBody>
                </InspectorControls>}
                {attributes.ordered && inheritedSettings && <InspectorControls>
                    <PanelBody
                        title={ __( 'Advanced List Controls', 'nested-ordered-lists-for-block-editor' ) }
                    >
                        <p>{ __( 'Settings inherited from parent list.', 'nested-ordered-lists-for-block-editor' ) }</p>
                    </PanelBody>
                </InspectorControls>}
            </Fragment>
        );
    };
}, 'withSidebarSelect' );
wp.hooks.addFilter(
    'editor.BlockEdit',
    'nolg/add-option-in-sidebar',
    addOptionInSidebar
);

/**
 * Save custom attribute for output in frontend.
 */
const saveAttributesForFrontend = ( extraProps, blockType, attributes ) => {
    // Do nothing if it's another block than our defined ones.
    if ( !enableSidebarSelectOnBlocks.includes( blockType.name ) ) {
        return extraProps;
    }

    // Do also nothing if it is not ordered
    if( !attributes.ordered ) {
        return extraProps;
    }

    // get attributes
    const { nestedList, listIntent } = attributes;

    // add class if we use a list-style
    if( attributes.type ) {
        extraProps.className = classnames( extraProps.className, 'nolg-style' );
    }

    // change some settings if our nested list is active
    if( nestedList ) {
        // add our own class
        extraProps.className = classnames( extraProps.className, 'nolg-list' );
        if( listIntent ) {
            // add additional class if intent should be used
            extraProps.className = classnames(extraProps.className, 'nolg-list-intent')
        }
        // add our level-settings
        extraProps = getCounterReset(extraProps, attributes);
    }

    // return resulting properties
    return extraProps;
};
wp.hooks.addFilter(
    'blocks.getSaveContent.extraProps',
    'nolg/save-attributes-for-frontend',
    saveAttributesForFrontend
);