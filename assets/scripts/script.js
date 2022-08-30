if (document.querySelector("#imgInp")) {

  imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
      imgName = file.name
      imgPreview.src = URL.createObjectURL(file)
      document.querySelector("#image_url").value = imgName.replaceAll(" ", "_").replaceAll("-","_")
      $("#imgPreview").show()
    }
  }
}

if(document.querySelector("#img-view")){
  $("#modify-btn").on("click",e=>{
    e.preventDefault()
    $("#img-input").show()
    $("#img-view").hide()
  })
  
  $("#modify-btn-cancel").on("click",e=>{
    e.preventDefault()
    $("#img-input").hide()
    $("#img-view").show()
  })

}

if(document.querySelector("#profile-form")){
  $("#btn-modify-profile").on('click',()=>{
    $("#profile-form").show()
    $("#btn-modify-profile-cancel").show()
    $("#profile-container").hide()

  })
  $("#btn-modify-profile-cancel").on('click',()=>{
    $("#profile-form").hide()
    $("#btn-modify-profile-cancel").hide()
    $("#profile-container").show()

  })
}

$(".up").on("click",()=>{
  $('html, body').animate({ scrollTop: 0 }, 'fast');
})