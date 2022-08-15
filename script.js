images = [...document.querySelectorAll("img")]

if(document.querySelector("#image_url")!==null){
  images.map(i=>{
      i.addEventListener("click",()=>{
document.querySelector("#image_url").value = i.getAttribute("data-src")
    })
  })  
}
//console.log(images);