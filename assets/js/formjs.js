const popup = document.querySelector("#c-popup");
const checkboxes = document.querySelectorAll(".c-input");
let count = 0;

console.log(checkboxes);

checkboxes.forEach( i => {
  i.addEventListener('change', () => {
  handleClick(i);
  });
});

function handleClick(cb) {
  
  if(!cb.checked){
    count -= 1;
  } else {
    count += 1;
  }
  
  if (count == checkboxes.length){
    popup.style.display = "block";
  } else {
    popup.style.display = "none";
  }
  
}
