
imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    imgName = file.name
    console.log(file);
    imgPreview.src = URL.createObjectURL(file)
    document.querySelector("#image_url").value = imgName.replaceAll(" ","_")
  }
}