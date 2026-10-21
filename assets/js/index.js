const form = document.querySelector("#cbForm");
const add = document.querySelector("#add");
const q = document.querySelector("#q");
const cb_q = document.querySelector("input[name='cb_q']");
const title = document.querySelector("input[name='title']");
const excede = document.querySelector("#excede");
const submit = document.querySelector("input[name='submit_data']");
const hidenInput = document.querySelector("input[name='q_all']");
let hiddenEditInput = document.querySelectorAll("input[name='cb_q_hidden']");
let q_list = [];

hiddenEditInput.forEach((i) => {
    q_list.push({"str": i.value });
});

title.addEventListener("input", () => {
     
     if(title.value.length > 255) {
        submit.disabled = true;
        excede.textContent = 'Έχετε ξεπεράσει το όριο χαρακτήρων (255)';
     } else {
        submit.disabled = false;
        excede.textContent= ' ';
     }
});

add.addEventListener("click", function () {
                
    let qinput = cb_q.value;
    const myRe = new RegExp("[.]$");
    const res = myRe.exec(qinput);

        if(res == null) {
            qinput = qinput + ".";
        }

    let str_input = {
    "str": qinput
    }
                
    q_list.push(str_input);
    cb_q.value = " ";
    displayQuestions();
                
});

form.addEventListener("submit", function () {
    let all = " ";
    q_list.forEach((input) => {
        all += input.str;
    })
    hidenInput.value = all;
});
    
function displayQuestions() {
    q.replaceChildren();   
    q_list.forEach((input, index) => {
    q.innerHTML += `<li><input type=text value=" ${input.str} "> | <span onclick='remove_q( ${index} )' class='remove pointer'>Διαγραφή</span></li>`;
    });
  }

function remove_q(index) {
    delete q_list[index];
    q.replaceChildren();
    displayQuestions();
} 

displayQuestions();