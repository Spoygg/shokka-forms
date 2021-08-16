const Edit = ({ attributes, setAttributes }) => {
  const { useBlockProps } = wp.blockEditor;

  return (
    <div {...useBlockProps()}>
      <button type='submit'>{attributes.text}</button>
    </div>
  );
};

export default Edit;
