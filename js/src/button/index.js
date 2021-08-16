import Edit from './edit';
import Save from './save';
import strings from './strings';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks;

registerBlockType('shokka-forms/button', {
  apiVersion: 2,
  name: 'shokka-forms/button',
  title: __('SF Button', 'shokka-forms'),
  icon: 'edit',
  category: 'common',
  description: __('Button control used to submit form.', 'shokka-forms'),
  textdomain: 'shokka-forms',
  edit: Edit,
  save: Save,
  attributes: {
    text: {
      type: 'string',
      source: 'text',
      selector: 'button',
      default: strings.button.text
    }
  }
});
