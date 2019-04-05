<?php 
session_start();
require 'header.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="asg2.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body onload="makeLoadingGifDisappear()">
        <img src="loading.gif" id="myLoadingGif">
<?php
    require_once('services/config.inc.php'); 
?>
<main class="container">
    <h1 id='title'>Companies</h1>
    <div class='col-1 col-s-1 large-ver'></div>
    <div class='col-1 col-s-1 filter'>
        <button class='btn'>Reset</button>
    </div>
    <div class='col-6 col-s-6 small-ver'>
        <ul id="small" style="list-style-type:none;"></ul>
    </div>
    <div class='col-6 col-s-6 symbol'>
        <ul id="sym" style="list-style-type:none;"></ul>
    </div>
    <div class='col-3 col-s-3 name'></div>
</main>
<script>
    function makeLoadingGifDisappear() {
     document.getElementById('myLoadingGif').style.display = 'none';
    }
    const itemsArray = [];
    const ul = document.querySelector('#small');
    const large = document.querySelector('.large-ver');
    const filter = document.createElement('input');
    const btn = document.querySelector('.btn');
    function createList(){
    
    //const sym = document.querySelector('#sym');
    // fetch from API
    const url = 'https://comp-3512-assignment-2-curtisloucks.c9users.io/w2019-assign2-master/services/companies.php';
    fetch(url)
     .then(function (response) {
         if (response.ok){
            return response.json();
         }
     })
    .then((data)=>{
                // add fetched data to the created array which will be used for display matches
                itemsArray.push(...data);
                data.forEach(function(d){
                    // a function to add all data to the list
                    function addTolist(){
                        let text= document.createTextNode(d.symbol);
                        let text2= document.createTextNode(d.name);
                        let img = document.createElement('img');
                        let span = document.createElement('span');
                        let span2 = document.createElement('span');
                        let li = document.createElement('li');
                        let a = document.createElement('a');
                        let a2 = document.createElement('a');
                        img.setAttribute('src',`logos/${d.symbol}.svg`);
                        img.setAttribute('title',d.symbol);
                        img.style.maxWidth = '100px';
                        img.style.height = '50px';
                        img.style.border = "1px solid black";
                        imageEvent(img,d);
                        li.appendChild(img);
                        a.setAttribute('href',`single-company.php?id=${d.symbol}`);
                        a2.setAttribute('href',`single-company.php?id=${d.symbol}`);
                        a.appendChild(text);
                        a2.appendChild(text2);
                        span.appendChild(a);
                        span2.appendChild(a2);
                        span.style.fontSize = '1em';
                        span.style.paddingLeft = '2em';
            
                        span2.style.fontSize = '1em';
                        span2.style.paddingLeft = '2em';
                        li.appendChild(span);
                        li.appendChild(span2);
                        ul.appendChild(li);

                    }
                    addTolist();
                });
            })
     .catch((error) => console.log(error));


    
    // add a search bar for users and set up an event listener when user search for company symble and press enter
    filter.setAttribute('type','text');
    filter.setAttribute('placeholder','Search then Press Enter');
    const bBox = document.querySelector('.filter');
    bBox.appendChild(filter);
    filter.addEventListener('change',displayMatches);
}
createList();
btn.addEventListener('click',function(){
    window.location.reload();
});
function imageEvent(img,item){
    img.addEventListener('mouseenter',function(){
                        large.style.display = "block";
                        large.innerHTML = "";
                        let img2 = document.createElement('img');
                        img2.setAttribute('src',`logos/${item.symbol}.svg`);
                        img2.setAttribute('title',item.symbol);
                        img2.style.maxWidth = '200px';
                        img2.style.height = '200px';
                        large.appendChild(img2);
                        
                    });
                    img.addEventListener('mouseleave',function(){
                        large.style.display = "none";
                        
                    });
                    img.addEventListener('mousemove',function(e){
                        let x = e.clientX;
                        let y = e.clientY;
                        large.style.marginTop = `${y/20}em`;
                        large.style.marginLeft = `${x/28}em`;
                        large.style.position = "fixed";
                        large.style.top = "50px";
                        large.style.left = "10px";

                        
                        
                    });
}
// handler for keyboard input
    function displayMatches() {
        // first remove all existing options from list
        ul.innerHTML = "";
        // don't start matching until user has typed at least one letter
        if (this.value.length >= 1) {
            const matches = findMatches(this.value, itemsArray);
            //  add results to the new list
             matches.forEach(item => {
                 let text= document.createTextNode(item.symbol);
                    let text2= document.createTextNode(item.name);
                    let img = document.createElement('img');
                    let span = document.createElement('span');
                    let span2 = document.createElement('span');
                    let li = document.createElement('li');
                    let a = document.createElement('a');
                    let a2 = document.createElement('a');
                    img.setAttribute('src',`logos/${item.symbol}.svg`);
                    img.setAttribute('title',item.symbol);
                    img.style.maxWidth = '100px';
                    img.style.height = '50px';
                    img.style.border = "1px solid black";
                    imageEvent(img,item);
                    li.appendChild(img);
                    a.setAttribute('href',`single-company.php?id=${item.symbol}`);
                    a2.setAttribute('href',`single-company.php?id=${item.symbol}`);
                    a.appendChild(text);
                    a2.appendChild(text2);
                    span.appendChild(a);
                    span2.appendChild(a2);
                    span.style.fontSize = 'large';
                    span.style.paddingLeft = '3em';
        
                    span2.style.fontSize = 'large';
                    span2.style.paddingLeft = '3em';
                    li.appendChild(span);
                    li.appendChild(span2);
                    ul.appendChild(li);

                });
            }
    
        // display error message if the user didn't type any thing and pressed enter
        else{
            let p = document.createElement('p');
            let msg = document.createTextNode('Please enter at least one character for your search!');
            p.appendChild(msg);
            p.style.backgroundColor = '#ccd4e0';
            p.style.border = '4px dotted blue';
            p.style.fontSize = 'small';
            ul.appendChild(p);
         }
     
        // display error message if there is no mathc
        if(ul.innerHTML == ""){
            let p = document.createElement('p');
            let msg = document.createTextNode('There is no match, please try again');
            p.appendChild(msg);
            p.style.backgroundColor = '#ccd4e0';
            p.style.border = '4px dotted blue';
            p.style.fontSize = 'small';
            ul.appendChild(p);
        }
     
    }
    

    // uses filter and regular expression to create list of matching symbols and images
    function findMatches(wordToMatch, itemsArray) {
         return itemsArray.filter(obj => {
         const regex = new RegExp("^(" + wordToMatch + ")", 'mgi');
         return obj.name.match(regex);
         });
    }

</script>

</body>
</html>