import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
    return (
        <div { ...useBlockProps() }>
            <p>{ __( 'Hello from the New Block!', 'card-block' ) }</p>
        </div>
    );
}
