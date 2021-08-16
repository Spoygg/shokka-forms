const { useBlockProps } = wp.blockEditor;

const Save = ({ attributes, setAttributes }) => {
  return (
    <div {...useBlockProps.save()}>
      <button type='submit' className='submit-button'>
        {attributes.text}
      </button>
    </div>
  );
};

export default Save;
