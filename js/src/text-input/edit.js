import SettingsPanel from './settings-panel';

const { useBlockProps, InspectorControls } = wp.blockEditor;

const Edit = ({ attributes, setAttributes }) => {
  return (
    <div {...useBlockProps()}>
      <InspectorControls key='setting'>
        <SettingsPanel attrs={{ attributes: attributes, setAttributes: setAttributes }} />
      </InspectorControls>
      <label>{attributes.label}</label>
      <input type={attributes.type} />
      {attributes.showDescription === false || (
        <span className='sf-description'>{attributes.description}</span>
      )}
    </div>
  );
};

export default Edit;
