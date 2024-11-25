import { registerBlockType } from '@wordpress/blocks';
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import './style.scss';

// Define block styles
const STYLES = [
    {
        name: 'red',
        label: __('Red', 'card-block'),
        isDefault: true,
    },
    {
        name: 'green',
        label: __('Green', 'card-block'),
    },
    {
        name: 'black',
        label: __('Black', 'card-block'),
    },
];

// Register the block
registerBlockType('card-block/notification', {
    apiVersion: 2,
    name: 'card-block/notification',
    title: __('Notification', 'card-block'),
    category: 'widgets',
    icon: 'smiley',
    example: {},
    styles: STYLES,

    edit: (props) => {
        return (
            <div {...useBlockProps()}>
                <h2 className="heading">{__('Notification', 'card-block')}</h2>
            </div>
        );
    },

    save: (props) => {
        console.log('Save Props:', props);
        return (
            <div { ...useBlockProps.save()}>
                <h2 className="heading">{__('Notification', 'card-block')}</h2>
            </div>
        );
    },
});
