/* Auxiliary functions for files */
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
}

/* Main functions: generate one page (page of publications and other pages) */
// for all pages except the publications
function generate_current_page(page_data) {
    console.log("generate all articles");
    console.log(page_data);

    var html = "";
    for(one_article_data of page_data) {
        html += generate_one_article(one_article_data, false);
    }
    return html;
}

// for the publication page
// page data: { category1: { ... all publis in category ...}, category2: { ... }, ... }
// associate each category/year with its respective publications
// then, generate one article per category/year
function generate_publication_page(page_data, sort_order) {
    var titles = {
        "journal": "Peer-reviewed international journals", "int_conf": "Peer-reviewed international conferences", "int_work": "Peer-reviewed international workshops", "nat_conf": "Peer-reviewed national conferences", "demo": "Demonstrations", "manuscript": "Manuscripts"
    };
    
    map_publication_sort = {};
    console.log(sort_order);
    // sort order is CATEGORY or YEAR
    for(category in page_data) {
        console.log(category);
        console.log(page_data[category]["descriptions"]);
        for(publication of page_data[category]["descriptions"]) {
            console.log(publication);
            publication_sort_value = publication[sort_order]; // a year or a category
            console.log(publication_sort_value);
            if(!(publication_sort_value in map_publication_sort)) {
                map_publication_sort[publication_sort_value] = [];
            }
            map_publication_sort[publication_sort_value].push(publication); 
        }
        console.log(map_publication_sort);
    }
    console.log(map_publication_sort);

    // then build the keys in order
    // for year: sort them by decreasing order
    // for categories, we already know the reight order
    sort_in_order = []
    if(sort_order == "category") {
        sort_in_order = ["journal", "int_conf", "int_work", "nat_conf", "demo", "manuscript"]
    } else if(sort_order == "year") {
        sort_in_order = Object.keys(map_publication_sort);
        // keys are now strings, we need to convert them to integer (match data.json)
        sort_in_order = sort_in_order.map((element) => parseInt(element));
        sort_in_order = sort_in_order.sort((a, b) => b-a); // decreasing order
    }
    console.log(sort_in_order);
    
    var current_publis = "";
    for(key of sort_in_order) { // iterate over the sorted categories/years
        console.log(key);
        var article_title = "";
        if(sort_order == "category") {
            article_title = titles[key]; // the pretty-print category
        } else {
            article_title = key; // the year
        }
        var group_of_publis = {
            "title": article_title,
            "descriptions": map_publication_sort[key]
        };
        console.log(group_of_publis);
        
        current_publis += generate_one_article(group_of_publis, true);
    }
    
    return current_publis;
}

/* individual functions */
// title is used for publication article titles only (which can be the cateogry or the year of publication)
function generate_one_article(article_data, publications) {
    console.log("generate one article");
    console.log(article_data);

    var html_1 = "";

    if(article_data != undefined && article_data != null) {
        html_1 += "<article class='postcard'>";
        html_1 += "<div class='myImage postcard__img_link'></div>";
        html_1 += "<div class='postcard__text t-dark'>";
        html_1 += "<div style='display: flex; justify-content: space-between;'>";
        html_1 += `<h4 class="postcard__title">${article_data["title"]}</h4>`;
        if(article_data["date"] != undefined && article_data["date"] != null) {
            html_1 += `<p style='float: right;'>${article_data["date"]}</p>`;
        }
        
        html_1 += "</div>";
        
        // subtitles
        if("subtitles" in article_data) {
            html_1 += "<div class='postcard__subtitle'>";
            i = 0;
            for(subtitle of article_data["subtitles"]) {
                // check whether the text of the subtitle should be converted to a <a> element or not
                if(subtitle[1].startsWith("http")) {
                    subtitle_text = `<a href='${subtitle[1]} target='_blank'>${subtitle[1]}</a>`
                } else {
                    subtitle_text = subtitle[1]
                }
                // create the subtitle with its image
                if(i === 0) {
                    html_1 += `<img src="images/${subtitle[0]}.svg" class="my-icon-first"/>${subtitle_text}`;
                } else {
                    html_1 += `<img src="images/${subtitle[0]}.svg" class="my-icon"/>${subtitle_text}`;
                }
                i = i + 1;
            }
            html_1 += "</div>";
        }


        // orange bar
        html_1 += "<div class='postcard__bar'></div>";

        // description
        if("descriptions" in article_data) {
            console.log("ici");
            html_1 += "<div class='postcard__preview-txt'>";

            if(publications) {
                sort_order = $("#sort_publis").find(":selected").val();
                console.log(article_data["descriptions"])
                html_1 += "<ol>";
                for(description of article_data["descriptions"]) {
                    html_1 += format_publication(description);
                }
                html_1 += "</ol>"
                
            } else {
                html_1 += "<ul>"
                for(description of article_data["descriptions"]) {
                    html_1 += `<li>${description}</li>`;
                }
                html_1 += "</ul>"
            }

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

    }

    return html_1;
}

/* Publication-related functions */
function sort_array(sort_order, the_array) {
    the_array_sorted = the_array.sort((a, b)=>{
        return  b[sort_order] - a[sort_order]  // year or category
    });
    return the_array;
}

function format_publication(publi) {
    var publi_as_html = "<li>";
    publi_as_html += display_authors(publi["authors"], 1, publi["main_author"]) + ". ";
    if(publi["url"] != undefined && publi["url"] != "") {
        publi_as_html += "<b><a href=\"" + publi["url"] + "\" target='_blank'>" + publi["title"] + ".</a></b> ";
    } else {
        publi_as_html += "<b>" + publi["title"] + ".</b> ";
    }
    publi_as_html += "<i>" + publi["venue"] + ".</i> ";
    publi_as_html += publi["year"] + ".";
    publi_as_html += "</li>";
    return publi_as_html;
}

function display_authors(author_list, style, main_author) {
    author_string = ""
    for(author of author_list) {
        // author is a JSON with two fields: first and last names
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
