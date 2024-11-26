import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { useBlockProps, PlainText } from '@wordpress/block-editor';
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
        content: {
            "type": "string",
            "default": "information"
        }
    },
    "style": "file:./style.scss",

    edit: ({ className, attributes, setAttributes }) => {
        const { style } = attributes;

        // Ensure the selected style is valid
        const selectedStyle = getStyleElements(STYLES, style);

        // Set the attribute if it is not already set
        if (style !== selectedStyle) {
            setAttributes({ style: selectedStyle });
        }

        const blockProps = useBlockProps({
            className: selectedStyle,
        });

        return (
            <div {...blockProps}>
                <h2 className={className}>
                    <PlainText
                        className={className}
                        onChange={(content) => setAttributes({ content })}
                        value={attributes.content}
                    />
                </h2>
            </div>
        );
    },

    save: ({ attributes }) => {
        const { className } = attributes;

        const blockProps = useBlockProps.save({
            className: className,
        });

        return (
            <div {...blockProps}>
                <h2 className={className}>{__(attributes.content, 'card-block')}</h2>
            </div>
        );
    },
});
