import { useBlockProps } from '@wordpress/block-editor';

export default function Save() {
    return (
        <div { ...useBlockProps.save() }>
            <p>Hello from the New Block!</p>
        </div>
    );
}
