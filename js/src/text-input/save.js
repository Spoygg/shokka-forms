const { useBlockProps } = wp.blockEditor;

const Save = ({ attributes }) => {
  return (
    <div {...useBlockProps.save()}>
      <label>{attributes.label}</label>
      <input type={attributes.type} name={attributes.name} value='' />
      {attributes.showDescription === false || (
        <span className='sf-description'>
          {attributes.description}
        </span>
      )}
    </div>
  );
};

export default Save;
