function generate_all_articles_of_a_page(page_data) {
    console.log("generate all articles");
    console.log(page_data);

    var html = "";

    for(one_article_data of page_data) {
        const html_one_page = generate_one_article(one_article_data);
        console.log(html_one_page);
        html += html_one_page;
    }

    return html;
}

// <article class="postcard">
//     <div class="myImage postcard__img_link">
//     </div>
//     <div class="postcard__text t-dark">
//         <h4 class="postcard__title">Young researcher project</h4>
//         <div class="postcard__subtitle">
//             <img src="images/calendar.svg" class="my-icon-first"/>Sept. 2025 - now 
//             <img src="images/person.svg" class="my-icon"/>leader
//             <img src="images/dollar.svg" class="my-icon"/>ANR JCJC (2026 – 2030)?
//         </div>
//         <div class="postcard__bar"></div>
//         <div class="postcard__preview-txt">
//             <ul>
//                 <li>Preparing a young researcher project about data lakes and federated learning.</li>
//                 <li>First proposal sent in Oct. 2025. Full proposal to be sent in March 2026.</li>
//             </ul>
//         </div>
//         <ul class="postcard__tagbox">
//             <li class="tag__item play"><img src="images/hashtag.svg" class="my-tag"/>data lake</li>
//             <li class="tag__item play"><img src="images/hashtag.svg" class="my-tag"/>FAIR data</li>
//             <li class="tag__item play"><img src="images/hashtag.svg" class="my-tag"/>federated learning</li>
//         </ul>
//     </div>
// </article>

function generate_one_article(article_data) {
    console.log("generate one article");
    console.log(article_data);

    var html_1 = "";

    html_1 += "<article class='postcard'>";
    html_1 += "<div class='myImage postcard__img_link'></div>";
    html_1 += "<div class='postcard__text t-dark'>";
    html_1 += `<h4 class="postcard__title">${article_data["title"]}</h4>`;
   
    // subtitles
    if("subtitles" in article_data) {
        html_1 += "<div class='postcard__subtitle'>";
        i = 0;
        for(subtitle of article_data["subtitles"]) {
            if(i === 1) {
                html_1 += `<img src="images/${subtitle[0]}.svg" class="my-icon-first"/>${subtitle[1]}`;
            } else {
                html_1 += `<img src="images/${subtitle[0]}.svg" class="my-icon"/>${subtitle[1]}`;
            }
            i = i + 1;
        }
        html_1 += "</div>";
    }


    // orange bar
    html_1 += "<div class='postcard__bar'></div>";

    // description
    if("descriptions" in article_data) {
        html_1 += "<div class='postcard__preview-txt'>";
        html_1 += "<ul>"
        for(description of article_data["descriptions"]) {
            html_1 += `<li>${description}</li>`;
        }
        html_1 += "</ul>"
        html_1 += "</div>"        
    }


    // tags
    if("tags" in article_data) {
        html_1 += "<ul class='postcard__tagbox'>";
        for(tag of article_data["tags"]) {
            html_1 += `<li class="tag__item play"><img src="images/${tag[0]}.svg" class="my-tag"/>${tag[1]}</li>`;
        }
        html_1 += "</ul>";
    }
    html_1 += "</article>"

    return html_1;
}

function readTextFile(file, callback) {
    var rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", file, false);
    rawFile.onreadystatechange = function() {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            callback(rawFile.responseText);
        }
    }
    rawFile.send(null);
}

function get_json_data(url) {
    var data = null;
    readTextFile(url, function(text){
        data = JSON.parse(text);
        console.log(data);
        return data;
    });
    return data;
    // return (function () {
    //     console.log("ici");
    //     var json = null;
    //     let xhttp = new XMLHttpRequest();
    //     xhttp.open("GET", url, false);
    //     // $.ajax({
    //     //     'async': false,
    //     //     'global': false,
    //     //     'url': url,
    //     //     'dataType': "json",
    //     //     'success': function (data) {
    //     //         console.log(data);
    //     //         json = data;
    //     //     }
    //     // });
    //     return json;
    // })();
}

function get_all_publications() {
    var journals = get_json_data("https://nelly-barret.github.io/publications/journals.json")
    journals.forEach(function (element) { element["category"] = CATEGORIES["JOURNAL"]; });
    var int_conferences = get_json_data("https://nelly-barret.github.io/publications/int_conferences.json")
    int_conferences.forEach(function (element) { element["category"] = CATEGORIES["INT_CONFERENCES"]; });
    var int_workshops = get_json_data("https://nelly-barret.github.io/publications/int_workshops.json");
    int_workshops.forEach(function (element) { element["category"] = CATEGORIES["INT_WORKSHOPS"]; });
    var nat_conferences = get_json_data("https://nelly-barret.github.io/publications/nat_conferences.json");
    nat_conferences.forEach(function (element) { element["category"] = CATEGORIES["NAT_CONFERENCES"]; });
    var demonstrations = get_json_data("https://nelly-barret.github.io/publications/demonstrations.json");
    demonstrations.forEach(function (element) { element["category"] = CATEGORIES["DEMONSTRATIONS"]; });
    var manuscripts = get_json_data("https://nelly-barret.github.io/publications/manuscripts.json");
    manuscripts.forEach(function (element) { element["category"] = CATEGORIES["MANUSCRIPTS"]; });
    
    all_publications = [];
    all_publications = all_publications.concat(journals);
    all_publications = all_publications.concat(int_conferences);
    all_publications = all_publications.concat(int_workshops);
    all_publications = all_publications.concat(nat_conferences);
    all_publications = all_publications.concat(demonstrations);
    all_publications = all_publications.concat(manuscripts);
    return all_publications;
}

function sort_array(sort_order, the_array) {
    the_array_sorted = the_array.sort((a, b)=>{
        return  b[sort_order] - a[sort_order]  // year or category
    });
    return the_array;
}

function display_authors(author_list, style, main_author) {
    author_string = ""
    for(author of author_list) {
        // author is a JSON with two fields: first and last
        console.log(main_author);
        if(main_author) {
            author_string += "<u>"
        }
        if(style == 1) {
            author_string += author["first"] + " " + author["last"];
        } else if(style == 2) {
            author_string += author["first"][0] + ". " + author["last"];
        } else if(style == 3) {
            author_string +=  author["last"] + author["first"][0] + ". ";
        } else if(style == 4) {
            author_string +=  author["last"];
        }
        if(main_author) {
            author_string += "</u>"
            main_author = false
        }
        author_string += ", "
    }
    author_string = author_string.substring(0, author_string.length-2);
    return author_string;
}

function create_html(sort_order, the_array) {
    $("#main_publis").empty();
    all_values = [];
    for(one_element of the_array) {
        all_values.push(one_element[sort_order]);
    }
    all_distinct_values = [...new Set(all_values)];
    for (iteration of all_distinct_values) { // distinct years or categories
        current_publis = "<ol>";
        console.log(iteration); // year or category
        for(publi of all_publications_sorted) {
            if(publi[sort_order] == iteration) {
                console.log(publi);
                current_publis += "<li>";
                current_publis += display_authors(publi["authors"], 1, publi["main_author"]) + ". ";
                if(publi["url"] != undefined && publi["url"] != "") {
                    current_publis += "<b><a href=\"" + publi["url"] + "\" target='_blank'>" + publi["title"] + ".</a></b> ";
                } else {
                    current_publis += "<b>" + publi["title"] + ".</b> ";
                }
                current_publis += "<i>" + publi["venue"] + ".</i> ";
                current_publis += publi["year"] + ".";
                current_publis += "</li>";
            }
            
        }
        current_publis += "</ol>";
        console.log(current_publis);
        $("#main_publis").append("<article class='postcard'><div class='postcard__text'><h4 class='postcard__title'>" + iteration + "</h1><div class='postcard__subtitle'></div><div class='postcard__bar'></div><div class='postcard__preview-txt' style='min-height: 10em;'>" + current_publis + "</div></div></article>");
    }
}

function show_publications() {
    console.log($("#sort_publis"));
    sort_order = $("#sort_publis").find(":selected").val(); // $("#sort_button").value TODO
    console.log("Sort order is " + sort_order);

    all_publications = get_all_publications();
    all_publications_sorted = sort_array(sort_order, all_publications);
    create_html(sort_order, all_publications_sorted);
}