import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import './style.scss';

// Define block styles
const STYLES = [
    {
        name: 'red',
        label: __('Red', 'card-block'),
       
    },
    {
        name: 'green',
        label: __('Green', 'card-block'),
    },
    {
        name: 'black',
        label: __('Black', 'card-block'),
    },
    {
        name: 'orange',
        label: __('Orange', 'card-block'),
        isDefault: true,
    }
];

function getStyleElements(styles, styleName) {
    let style = styles.find(style => style.name === styleName);
    return style ? style.name : 'red'; // Default to "red" if not found
}

// Register the block
registerBlockType('card-block/notification', {
    apiVersion: 2,
    name: 'card-block/notification',
    title: __('Notification', 'card-block'),
    category: 'CardBlock',
    icon: 'smiley',
    example: {},
    styles: STYLES,
    attributes: {
        style: {
            type: 'string',
            default: 'red', // Default style
        },
    },

    edit: ({ attributes, setAttributes }) => {
        const { style } = attributes;

        // Ensure the selected style is valid
        const selectedStyle = getStyleElements(STYLES, style);

        // Set the attribute if it is not already set
        if (style !== selectedStyle) {
            setAttributes({ style: selectedStyle });
        }

        const blockProps = useBlockProps({
            className: selectedStyle, // Apply selected style as a class
        });

        return (
            <div {...blockProps}>
                <h2>{__('Notification', 'card-block')}</h2>
            </div>
        );
    },

    save: ({ attributes }) => {
        const { style } = attributes;

        const blockProps = useBlockProps.save({
            className: style, // Apply style class for frontend
        });

        return (
            <div {...blockProps}>
                <h2>{__('Notification', 'card-block')}</h2>
            </div>
        );
    },
});
