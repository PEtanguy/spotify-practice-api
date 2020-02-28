/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// const $ = require('jquery')
// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// fetch(`https://api.spotify.com/v1/me/top/artists?time_range=medium_term&limit=10&offset=5`, {
//   headers: {
//     'Authorization': 'Bearer ' + "BQALWgncud3QVWPgA77VWWSsvvl-cvQ3D8HhTkYu7YylCBq1bz0qhNI-j-bBA87BqaH1kLjMhlMhYLZTZ8wDe_fu_W6iXldJgW7zN_CE8RQqzgl_NawpODPvaZwZtC4iurcIr8c2v1NrhteqTSkM7EG4OtP9rGDO9re74a3tP00wu_HN0n7sl-mNFQyEixAN1VmANDNlATEO4bmtwV7b9EvRF93pY3ZkzpZIX6X0Nym_HIONPBni60_UgQE-ddPfi3J5eKmmgfql8g"
// }})
//   .then((data) => {
//     console.log(data);
//   });
const cards = document.querySelectorAll(".main-artist");
cards.forEach((card) => {
  card.addEventListener('mouseover', function(){
    console.log(event.currentTarget.nextElementSibling);
    event.currentTarget.nextElementSibling.classList.toggle("d-none")
  });
  card.addEventListener('mouseout', function(){
    console.log(event.currentTarget.nextElementSibling);
    event.currentTarget.nextElementSibling.classList.toggle("d-none")
  });
})
