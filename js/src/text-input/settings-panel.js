import strings from './strings';
const { __ } = wp.i18n;
const {
  Panel,
  PanelBody,
  PanelRow,
  CheckboxControl,
  TextControl,
  TextareaControl,
  SelectControl
} = wp.components;

const SettingsPanel = (props) => {
  const { attributes, setAttributes } = props.attrs;

  const ensureUniqueName = () => {
    // Check if name still holds the default value, if so ensure it is set to something else.
    if (attributes.name === 'text-input') {
      setAttributes({ name: 'text-input-' + parseInt(Math.random() * 1000) });
    }
  };

  const onLabelChange = (value) => {
    setAttributes({ label: value || strings.inputText.label });
    ensureUniqueName();
  };

  const onShowDescriptionChange = (value) => {
    setAttributes({ showDescription: value });
  };

  const onTypeChange = (value) => {
    setAttributes({ type: value });
  };

  const onNameChange = (value) => {
    setAttributes({ name: value });
  };

  const onDescriptionChange = (value) => {
    setAttributes({ description: value });
  };

  return (
    <div>
      <Panel>
        <PanelBody title={__('Block Settings')} initialOpen>
          <PanelRow>
            <TextControl
              label={__('Field label', 'shokka-forms')}
              value={attributes.label}
              onChange={onLabelChange}
            />
          </PanelRow>
          <PanelRow>
            <CheckboxControl
              label={__('Show description', 'shokka-forms')}
              help={__(
                'Show field description under the field.',
                'shokka-forms'
              )}
              checked={attributes.showDescription}
              onChange={onShowDescriptionChange}
            />
          </PanelRow>
          {attributes.showDescription === false || (
            <PanelRow>
              <TextareaControl
                label={__('Field description', 'shokka-forms')}
                value={attributes.description}
                onChange={onDescriptionChange}
              />
            </PanelRow>
          )}
          <PanelRow>
            <TextControl
              label={__('Field name', 'shokka-forms')}
              help={__(
                'Field value will be stored under name chosen here. Each field should have a unique field name.',
                'shokka-forms'
              )}
              value={attributes.name}
              onChange={onNameChange}
            />
          </PanelRow>
          <PanelRow>
            <SelectControl
              label={__('Type:', 'shokka-forms')}
              value={attributes.type}
              onChange={onTypeChange}
              options={[
                {
                  value: null,
                  label: __('Select a type...', 'shokka-forms'),
                  disabled: true
                },
                { value: 'text', label: __('Text', 'shokka-forms') },
                { value: 'number', label: __('Number', 'shokka-forms') },
                { value: 'email', label: __('Email address', 'shokka-forms') },
                { value: 'password', label: __('Password', 'shokka-forms') },
                { value: 'tel', label: __('Telephone number', 'shokka-forms') },
                { value: 'date', label: __('Date', 'shokka-forms') },
                { value: 'time', label: __('Time', 'shokka-forms') }
              ]}
              help={__(
                'Type affects how text input is validated and supported browsers provide different UI based on type.',
                'shokka-forms'
              )}
            />
          </PanelRow>
        </PanelBody>
      </Panel>
    </div>
  );
};

export default SettingsPanel;
