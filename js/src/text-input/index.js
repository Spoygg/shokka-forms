import Edit from './edit';
import Save from './save';
import strings from './strings';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('shokka-forms/text-input', {
  apiVersion: 2,
  name: 'shokka-forms/text-input',
  title: __('SF Text Input', 'shokka-forms'),
  icon: 'edit',
  category: 'common',
  description: __('Text input field block.', 'shokka-forms'),
  textdomain: 'shokka-forms',
  edit: Edit,
  save: Save,
  attributes: {
    label: {
      type: 'string',
      default: strings.inputText.label
    },
    description: {
      type: 'string',
      default: strings.inputText.description
    },
    showDescription: {
      type: 'boolean',
      default: false
    },
    name: {
      type: 'string',
      default: 'text-input'
    },
    type: {
      enum: [
        'text',
        'number',
        'email',
        'tel',
        'date',
        'time'
      ],
      default: 'text'
    }
  }
});
