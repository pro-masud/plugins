import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit() {
    return (
        <div { ...useBlockProps() } className="new-block-hover-container">
            <div className="new-block-content">
                <p>{ __( 'Hover over this block!', 'card-block' ) }</p>
            </div>
            <div className="new-block-hover-view">{ __( 'View', 'card-block' ) }</div>
        </div>
    );
}