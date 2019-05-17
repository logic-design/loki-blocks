(function( blocks, element, editor, components, i18n ) {

	const { registerBlockType } = blocks;
	const { RichText } = editor;
	const { createElement } = element;
	const { InspectorControls } = editor;
	const { SelectControl, ToggleControl } = components;
	const { __ } = i18n;
	const lokiIcon = createElement('svg', {
			width: 20,
			height: 20
		},
		createElement('path', {
			d: 'M 17.203125 3.445312 C 16.933594 1.789062 16.144531 0.628906 14.988281 0.1875 C 14.601562 0.0390625 14.1875 -0.0195312 13.757812 0.0078125 C 13.585938 0.015625 13.4375 0.125 13.378906 0.285156 C 13.316406 0.445312 13.355469 0.625 13.472656 0.746094 C 14.050781 1.332031 14.410156 2.316406 14.480469 3.519531 C 14.558594 4.808594 14.316406 6.230469 13.78125 7.636719 C 13.636719 8.007812 13.480469 8.367188 13.304688 8.714844 C 12.363281 7.976562 11.210938 7.578125 10 7.578125 C 8.789062 7.578125 7.636719 7.976562 6.695312 8.714844 C 6.519531 8.367188 6.363281 8.007812 6.21875 7.636719 C 5.683594 6.230469 5.441406 4.808594 5.519531 3.519531 C 5.589844 2.316406 5.949219 1.332031 6.527344 0.746094 C 6.644531 0.625 6.683594 0.445312 6.621094 0.285156 C 6.5625 0.125 6.414062 0.015625 6.242188 0.0078125 C 5.8125 -0.0195312 5.398438 0.0390625 5.011719 0.1875 C 3.855469 0.628906 3.066406 1.789062 2.796875 3.445312 C 2.542969 5.019531 2.78125 6.882812 3.472656 8.6875 C 3.847656 9.664062 4.363281 10.628906 4.875 11.320312 C 4.707031 11.847656 4.621094 12.394531 4.621094 12.957031 L 4.621094 18.265625 C 4.621094 18.4375 4.726562 18.59375 4.886719 18.664062 L 7.890625 19.964844 C 7.945312 19.988281 8.003906 20 8.0625 20 C 8.144531 20 8.230469 19.976562 8.300781 19.929688 C 8.421875 19.847656 8.496094 19.710938 8.496094 19.566406 L 8.496094 16.496094 C 8.496094 16.257812 8.300781 16.0625 8.0625 16.0625 L 6.984375 16.0625 L 6.984375 13.480469 L 9.832031 14.683594 C 9.832031 14.6875 9.835938 14.6875 9.835938 14.6875 C 9.84375 14.691406 9.847656 14.691406 9.855469 14.695312 C 9.863281 14.695312 9.871094 14.699219 9.878906 14.703125 C 9.882812 14.703125 9.886719 14.703125 9.890625 14.707031 C 9.894531 14.707031 9.898438 14.707031 9.90625 14.707031 C 9.914062 14.710938 9.921875 14.710938 9.933594 14.714844 C 9.9375 14.714844 9.941406 14.714844 9.945312 14.714844 C 9.945312 14.714844 9.949219 14.714844 9.953125 14.71875 C 9.964844 14.71875 9.976562 14.71875 9.988281 14.71875 C 9.992188 14.71875 9.996094 14.71875 10 14.71875 C 10.003906 14.71875 10.007812 14.71875 10.007812 14.71875 C 10.023438 14.71875 10.035156 14.71875 10.046875 14.71875 C 10.050781 14.714844 10.054688 14.714844 10.054688 14.714844 C 10.058594 14.714844 10.0625 14.714844 10.066406 14.714844 C 10.078125 14.710938 10.085938 14.710938 10.09375 14.707031 C 10.101562 14.707031 10.105469 14.707031 10.109375 14.707031 C 10.113281 14.703125 10.117188 14.703125 10.117188 14.703125 C 10.128906 14.699219 10.136719 14.695312 10.144531 14.695312 C 10.152344 14.691406 10.15625 14.691406 10.164062 14.6875 C 10.164062 14.6875 10.167969 14.6875 10.167969 14.6875 C 10.167969 14.683594 10.167969 14.683594 10.167969 14.683594 L 13.015625 13.480469 L 13.015625 16.0625 L 11.9375 16.0625 C 11.699219 16.0625 11.503906 16.257812 11.503906 16.496094 L 11.503906 19.566406 C 11.503906 19.804688 11.699219 20 11.9375 20 L 12.316406 20 C 12.386719 20 12.449219 19.984375 12.511719 19.953125 L 15.136719 18.652344 C 15.285156 18.582031 15.378906 18.429688 15.378906 18.265625 L 15.378906 12.957031 C 15.378906 12.394531 15.292969 11.847656 15.125 11.320312 C 15.636719 10.628906 16.152344 9.664062 16.527344 8.6875 C 17.214844 6.882812 17.457031 5.019531 17.203125 3.445312 Z M 6.71875 12.425781 C 6.585938 12.367188 6.429688 12.382812 6.308594 12.460938 C 6.1875 12.542969 6.113281 12.679688 6.113281 12.824219 L 6.113281 16.496094 C 6.113281 16.738281 6.308594 16.933594 6.550781 16.933594 L 7.628906 16.933594 L 7.628906 18.902344 L 5.492188 17.980469 L 5.492188 12.957031 C 5.492188 12.523438 5.554688 12.101562 5.671875 11.695312 L 8.160156 11.800781 L 9.027344 13.402344 Z M 14.507812 17.996094 L 12.371094 19.054688 L 12.371094 16.933594 L 13.449219 16.933594 C 13.691406 16.933594 13.886719 16.738281 13.886719 16.496094 L 13.886719 12.824219 C 13.886719 12.679688 13.8125 12.542969 13.691406 12.460938 C 13.570312 12.382812 13.414062 12.367188 13.28125 12.425781 L 10.972656 13.402344 L 11.839844 11.800781 L 14.328125 11.695312 C 14.445312 12.101562 14.507812 12.523438 14.507812 12.957031 Z M 15.714844 8.375 C 15.367188 9.28125 14.878906 10.199219 14.410156 10.820312 L 11.554688 10.945312 C 11.402344 10.949219 11.265625 11.035156 11.191406 11.171875 L 10 13.371094 L 8.808594 11.171875 C 8.734375 11.035156 8.597656 10.949219 8.445312 10.945312 L 5.589844 10.820312 C 5.121094 10.199219 4.632812 9.28125 4.285156 8.375 C 3.648438 6.710938 3.425781 5.011719 3.65625 3.585938 C 3.871094 2.273438 4.441406 1.367188 5.269531 1.019531 C 4.917969 1.6875 4.707031 2.515625 4.648438 3.46875 C 4.566406 4.878906 4.828125 6.425781 5.410156 7.945312 C 5.628906 8.523438 5.886719 9.074219 6.179688 9.59375 C 6.1875 9.605469 6.195312 9.621094 6.203125 9.632812 C 6.277344 9.765625 6.355469 9.898438 6.433594 10.027344 C 6.5625 10.230469 6.828125 10.292969 7.035156 10.167969 C 7.238281 10.039062 7.300781 9.769531 7.171875 9.566406 C 7.15625 9.539062 7.140625 9.511719 7.125 9.484375 C 7.929688 8.8125 8.941406 8.449219 10 8.449219 C 11.058594 8.449219 12.070312 8.8125 12.875 9.484375 C 12.859375 9.511719 12.84375 9.539062 12.828125 9.566406 C 12.699219 9.769531 12.761719 10.039062 12.964844 10.167969 C 13.171875 10.292969 13.4375 10.230469 13.566406 10.027344 C 13.644531 9.898438 13.722656 9.765625 13.796875 9.632812 C 13.804688 9.621094 13.8125 9.609375 13.820312 9.59375 C 14.113281 9.074219 14.371094 8.523438 14.589844 7.945312 C 15.171875 6.425781 15.433594 4.878906 15.351562 3.46875 C 15.292969 2.515625 15.082031 1.6875 14.730469 1.019531 C 15.558594 1.367188 16.128906 2.273438 16.34375 3.585938 C 16.574219 5.011719 16.351562 6.710938 15.714844 8.375 Z M 15.714844 8.375',
			},
		),
	);

	function hashCode(str) {
		var hash = 0, i, chr;
		if (!str || str.length === 0)
			return hash;
		for (i = 0; i < str.length; i++) {
			chr  = str.charCodeAt(i);
			hash = ((hash << 5) - hash) + chr;
			hash |= 0;
		}
		return hash;
	}

	registerBlockType( 'loki/accordion', {
		title: __( 'Loki Accordion', 'accordion' ),
		icon: lokiIcon,
		category: 'loki-blocks',
		keywords: [ __( 'section' ), __( 'header' ) ],
		customClassName: false,
		className: false,
		attributes: {
			question: {
				source: 'children',
				selector: '.loki-accordion-question',
				default: 'Question...'
			},
			answer: {
				source: 'children',
				selector: '.loki-tab-content',
				default: 'Answer...'
			},
			hash: {
				source: 'attribute',
				attribute: 'id',
				selector: 'input',
				default: ''
			}
		},

		save: function( props ) {
			const question = props.attributes.question;
			const answer = props.attributes.answer;
			const hash = props.attributes.hash;
			const container = createElement(
				'div', { className: 'loki-accordion-block' },
				React.createElement('input', { id: hash, name: hash, type: 'checkbox' }),
				createElement( RichText.Content, { tagName: 'label', className: 'loki-accordion-question', value: question, htmlFor: hash }),
				React.createElement('div', { className: 'loki-tab-answer' },
					createElement( RichText.Content, { tagName: 'div', className: 'loki-tab-content', value: answer })
				)
			);
			return container;
		},

		edit: function( props ) {
			const question = props.attributes.question;
			const answer = props.attributes.answer;
			const focus = props.focus;

			function onChangeQuestion( newContent ) {
				props.setAttributes( { question: newContent } );
				props.setAttributes( { hash: Math.random().toString(36).substr(2, 9) } );
			}

			function onChangeAnswer( newContent ) {
				props.setAttributes( { answer: newContent } );
			}

			const editQuestion = createElement(
				RichText,
				{
					tagName: 'h3',
					onChange: onChangeQuestion,
					value: question,
					focus: focus,
					onFocus: props.setFocus,
				}
			);
			const editAnswer = createElement(
				RichText,
				{
					tagName: 'p',
					onChange: onChangeAnswer,
					value: answer,
					focus: focus,
					onFocus: props.setFocus,
				}
			);
			return createElement(
				'div', { key: 'loki-accordion-block-div', className: 'loki-accordion-block' },
				//React.createElement('input', { id: 'loki-faq-block', name: 'loki-faq-block', type: 'checkbox' }),
				editQuestion,
				editAnswer
			);
		},

	});

})(
	window.wp.blocks,
	window.wp.element,
	window.wp.editor,
	window.wp.components,
	window.wp.i18n
);
