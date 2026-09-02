document.addEventListener("DOMContentLoaded", function () {

    console.log("Page navigation initialized");

    const container =
        document.getElementById("pageNavContainer");

    const menu =
        document.getElementById("pageNavMenu");

    const button =
        document.getElementById("pageNavDropdown");


    console.log("container:", container);
    console.log("menu:", menu);
    console.log("button:", button);


    if (!container || !menu || !button) {
        console.log("Navigation elements missing");
        return;
    }


    const sections =
        document.querySelectorAll(".page-nav-section");


    console.log("Sections found:", sections.length);


    if (sections.length === 0) {

        container.style.display = "none";

        return;
    }


    sections.forEach(function (section, index) {

        console.log(
            "Section:",
            section.id,
            section.textContent.trim()
        );


        // Create ID if necessary
        if (!section.id) {
            section.id = "page-section-" + index;
        }


        // Create <li>
        const li = document.createElement("li");


        // Create <a>
        const link = document.createElement("a");

        link.className = "dropdown-item";

        link.href = "#" + section.id;

        link.textContent =
            section.textContent.trim();


        // Add link to li
        li.appendChild(link);


        // Add li to menu
        menu.appendChild(li);

    });


    console.log(
        "Menu now contains:",
        menu.children.length,
        "items"
    );

});
