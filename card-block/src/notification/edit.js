import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import "./editor.scss";

export default function Edit({className}) {

    return (
        <div>
            <p  { ...useBlockProps() }>{ __( 'Hello from the New Block!', 'card-block' ) }</p>
        </div>
    );
}
