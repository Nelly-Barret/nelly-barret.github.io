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
function generate_current_page(page_data, page_name) {
    console.log("generate all articles");
    console.log(page_data);

    var html = "";
    for(one_article_data of page_data) {
        html += generate_one_article(one_article_data, page_name);
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
        
        current_publis += generate_one_article(group_of_publis, "publications");
    }
    
    return current_publis;
}

/* individual functions */
// title is used for publication article titles only (which can be the category or the year of publication)
function generate_one_article(article_data, page_name) {
    console.log("generate one article");
    console.log(article_data);

    var html_1 = "";

    if(article_data != undefined && article_data != null) {
        html_1 += "<article class='postcard'>";
		if(page_name == "research_projects") {
			if("image" in article_data) {
				html_1 += "<div class='myImage postcard__img_link'>"
				html_1 += `<img class='postcard__img' src='${article_data["image"]}' alt='${article_data["alt"]}' />`
				html_1 += "</div>"
			}
		}
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
                // create the subtitle with its icon
                if(i === 0) {
                    html_1 += `<i class="fa-solid fa-${subtitle[0]} my-icon-first"/>${subtitle_text}`;
					// html_1 += `<img src="images/${subtitle[0]}.svg" class="my-icon-first"/>${subtitle_text}`;
                } else {
                    html_1 += `<i class="fa-solid fa-${subtitle[0]} my-icon"/>${subtitle_text}`;
					// html_1 += `<img src="images/${subtitle[0]}.svg" class="my-icon"/>${subtitle_text}`;
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

            if(page_name == "publications") {
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
                    if(typeof(description) == "object") {
                        // an object description with a text and a url
                        if("url" in description) {
                            if(description["url"].includes("zenodo")) {
                                icon = "fa-solid fa-chalkboard-user"
                            } else if(description["url"].includes("youtube")) {
                                icon = "fa-brands fa-youtube"
                            } else {
                                icon = "fa-solid fa-chalkboard-user"
                            }
                            
                            html_1 += `<li>${description["title"]}<a href="${description["url"]}" target="_blank"><i class="${icon} my-icon"></i></a></li>`;
                        } else {
                            html_1 += `<li>${description["title"]}</li>`;
                        }
                    } else {
                        // a simple textual description
                        html_1 += `<li>${description}</li>`;
                    }
                    
                }
                html_1 += "</ul>"
            }

            html_1 += "</div>"        
        }

        // tags
        if("tags" in article_data) {
            html_1 += "<ul class='postcard__tagbox'>";
            for(tag of article_data["tags"]) {
                html_1 += `<li class="tag__item play"><i class="fa-solid fa-${tag[0]} my-tag"></i>${tag[1]}</li>`;
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
	if("paper" in publi && publi["paper"] != "") {
		publi_as_html += "<a href=\"" + publi["paper"] + "\" target='_blank' title='PDF paper'><i class='fa-regular fa-file-pdf my-icon' style='color: black;'></i></a>"
	}
	if("slides" in publi && publi["slides"] != "") {
		publi_as_html += "<a href=\"" + publi["slides"] + "\" target='_blank' title='Slides'><i class='fa-solid fa-chalkboard-user my-icon' style='color: black;'></i></a>"
	}
	if("poster" in publi && publi["poster"] != "") {
		publi_as_html += "<a href=\"" + publi["poster"] + "\" target='_blank' title='Poster'><i class='fa-regular fa-newspaper my-icon' style='color: black;'></i></a>"
	}
	if("video" in publi && publi["video"] != "") {
		publi_as_html += "<a href=\"" + publi["video"] + "\" target='_blank' title='Video'><i class='fa-solid fa-video my-icon' style='color: black;'></i></a>"
	}
	if("bib" in publi) {
		publi_as_html += "<button data-toggle='collapse' data-target='#collapse" + publi["bib"]["citation"] + "' aria-expanded='false' aria-controls='collapse" + publi["bib"]["citation"] + "' style='border: none; background-color: transparent;'><i class='fa-brands fa-tex my-icon' style='color: black;'></i></a></li><div class='collapse' id='collapse" + publi["bib"]["citation"] + "'><div class='card card-body'>" + display_bib(publi) + "</div></div>";
	} else {
		publi_as_html += "</li>";
	}
    return publi_as_html;
}

function display_bib(publi_record) {
	html_bib = "@" + publi_record["bib"]["type"] + " {" + publi_record["bib"]["citation"] + ", <br/>";
	html_bib += "&nbsp;&nbsp;title={" + publi_record["title"] + "}, <br/>";
	authors = publi_record["authors"].map(author => author["last"] + ", " + author["first"] + " and ");
	console.log(authors);
	authors = authors.join("");
	authors = authors.substring(0, authors.length - 5) // remove last "and" from the string
	html_bib += "&nbsp;&nbsp;author={" + authors + "}, <br/>";
	if(publi_record["bib"]["type"] == "phdthesis") {
		html_bib += "&nbsp;&nbsp;school={" + publi_record["venue"] + "}, <br/>";
	} else {
		html_bib += "&nbsp;&nbsp;booktitle={" + publi_record["venue"] + "}, <br/>";
	}
	html_bib += "&nbsp;&nbsp;year={" + publi_record["year"] + "}, <br/>";
	// add all other fields in the bib entry
	for(const [key, value] of Object.entries(publi_record["bib"])) {
		if(!["type", "citation"].includes(key)) {
			// this is NOT a key that we already put (authors, title, type)
			html_bib += "&nbsp;&nbsp;" + key + "={" + value + "}, <br/>";
		}
	}
	// remove comma after last entry and add final }
	console.log(html_bib);
	html_bib = html_bib.substring(0, html_bib.length - 7);
	console.log(html_bib);
	html_bib += "<br/>}";
	console.log(html_bib);
	return html_bib;
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
