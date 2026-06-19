document.addEventListener('DOMContentLoaded',()=>{

 document.getElementById('cityStart').addEventListener('change',(e)=>{
    let cityStart = e.currentTarget.value;
    console.log(cityStart);
    
    if(cityStart == ''){
        return;
    }

    fetch('index.php?action=getCityEnd',{
        method : 'POST',
        headers : {
            'Content-Type' : 'application/x-www-form-urlencoded'
        },
        body : 'villeDepart='+encodeURIComponent(cityStart)
    })
    .then(response =>response.text())
    .then(((villes) =>{
      let cityEnds = document.getElementById('cityEnd');
      cityEnds.innerHTML = villes;
      console.log(villes);
    } ))
    .catch(e => console.error('Erreur : ',e.message));

 })

})