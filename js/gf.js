
// Radio Buttons Elements.
const radioElems = document.querySelectorAll('input[name="guild_level"]');

// Select Tag Which Will Hold Completed Quests.
const selectElem = document.querySelector("#comp-q")

// Bonus Quest Checkbox.
const bonusQ = document.querySelector('input[name="include_bonus"]');



// Array Holds Completed Quests Based On Guild Level
const q = {
    master: "10",
    expert: "9",
    advanced: "8",
    intermediate: "7",
    beginner: "6"
};

// Quests Number.
let qNum;

// Loop Radio Button
for (const radio of radioElems) {
    // When Select One.
    radio.addEventListener('change', function () {
        selectElem.innerHTML = "";
        if (this.checked) {
            switch (this.id) {
                case "master":
                    qNum = q.master;
                    break;
                case "expert":
                    qNum = q.expert;
                    break;
                case "advanced":
                    qNum = q.advanced;
                    break;
                case "intermediate":
                    qNum = q.intermediate;
                    break;
                case "beginner":
                    qNum = q.beginner;
            }

            for (let i = 1; i <= qNum; i++) {
                let opt = document.createElement("option");
                opt.setAttribute("value", `${i}`);
                opt.textContent = i;
                selectElem.appendChild(opt);
            }

        }



    });
}

// Show more information on output card once details button is clicked.
$("#expand-output-details").click(function () {
    $("#output-details").toggle();
});
