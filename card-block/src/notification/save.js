import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Save() {
    return (
        <div>
            <p { ...useBlockProps.save() }>{ __( 'Hello from the New Block!', 'card-block' ) }</p>
        </div>
    );
}
