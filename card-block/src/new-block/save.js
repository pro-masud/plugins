import { useBlockProps } from '@wordpress/block-editor';

export default function Save() {
    return (
        <div { ...useBlockProps.save() } className="new-block-hover-container">
            <div className="new-block-content">
                <p>Hover over this block!</p>
            </div>
            <div className="new-block-hover-view">View</div>
        </div>
    );
}
