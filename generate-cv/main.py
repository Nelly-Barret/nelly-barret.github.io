import json
import urllib.request

from docx import Document
from docx.shared import Inches
from docx2pdf import convert

from constants import IMAGE_SECTIONS, IMAGES_MAP
from utils import insert_horizontal_rule, add_hyperlink


# 1. create template for NINJA, i.e., the Word document wit the NINJA tags ({{tag}})
def generate_long_cv(template, data_file_url, generated_filename):
    generated_doc = Document(template)


    with urllib.request.urlopen(data_file_url) as url:
        data = json.load(url)
        print(data)
        page_names = list(data.keys())
        page_names.remove("header")  # remove the header info because it should not be part of the main loop
        pretty_page_names = {page_name: page_name.replace("_", " ").capitalize() for page_name in page_names}
        print(page_names)
        print(pretty_page_names)

        # header
        generated_doc.add_heading(data["header"]["current_name"], level=0)
        generated_doc.add_paragraph(data["header"]["current_position"], style="Subtitle")
        generated_doc.add_heading(data["header"]["current_address"], level=1)
        generated_doc.add_heading(f"{data["header"]["current_office"]} | {data["header"]["current_emailaddress"]} | {data["header"]["current_orcid"]}", level=2)

        # generate sections for each other page
        for page_name in page_names:
            heading = generated_doc.add_heading()
            run_heading = heading.add_run()
            run_heading.add_picture(f"../images/{IMAGE_SECTIONS[page_name]}.png", width=Inches(0.25))
            run_heading.add_text(f" {pretty_page_names[page_name]}")  # keep a space after the section image
            #generated_doc.add_heading(pretty_page_names[page_name], level=1)
            paragraph_horizontal_rule = generated_doc.add_paragraph()
            insert_horizontal_rule(paragraph_horizontal_rule)
            if page_name == "research_interests":
                # no individual sections for the research interest page
                # however, we still need to add the paragraph
                generated_doc.add_paragraph(data[page_name][0]["descriptions"][0])
            else:
                for section in data[page_name]:
                    if section["title"].lower() == "stay tuned":
                        pass
                    else:
                        # specific titles of the form "title | location     date"
                        if page_name in ["academic_positions", "education", "awards"]:
                            section_title = f"{section["title"]} | {section["subtitles"][0][1]}"
                        else:
                            section_title = section["title"]
                        # regular titles
                        if "date" in section:
                            generated_doc.add_heading(f"{section_title}\t{section["date"]}", level=2)  # four curly-braces: the 2 to show + the 2 to escape the first two
                        else:
                            generated_doc.add_heading(section_title, level=2)  # four curly-braces: the 2 to show + the 2 to escape the first two

                        if "subtitles" in section:
                            if page_name in ["academic_positions", "education", "awards"] and len(section["subtitles"]) == 1 and section["subtitles"][0][0] == "map-pin":
                                # there is only one subtitle and this subtitle is the location
                                # we previously added it to the section title
                                # so we do not create a paragraph for that subtitle
                                # rather, we create paragraphs when there are more subtitles
                                pass
                            else:
                                i = 1
                                paragraph = generated_doc.add_paragraph()
                                for one_subtitle in section["subtitles"]:
                                    if i == 1 and one_subtitle[0] == "map-pin":
                                        pass
                                    else:
                                        subtitle_img = one_subtitle[0]
                                        subtitle_text = one_subtitle[1]
                                        run_text = paragraph.add_run()
                                        # run.add_picture(f"../images/{subtitle_img}.png", width=Inches(0.15))
                                        run_text.add_text(f"{IMAGES_MAP[subtitle_img]}: ")  # Role, Grant, Website, etc
                                        run_text.italic = True
                                        if subtitle_img in ["website", "code-branch"] and subtitle_text.startswith("https://"):
                                            run_text_2 = add_hyperlink(paragraph, subtitle_text.replace("https://", ""), subtitle_text, False)
                                        else:
                                            run_text_2 = paragraph.add_run()
                                            run_text_2.add_text(f"{subtitle_text}") # leader, JCJC, etc
                                        if i < len(section["subtitles"]):
                                            run_text_2.add_text(" | ")
                                    i += 1
                        if "descriptions" in section:
                            if page_name == "publications":
                                # special case: we need to format each publication authors, title, etc
                                for one_description in section["descriptions"]:
                                    format_publication(generated_doc, one_description)
                            else:
                                for one_description in section["descriptions"]:
                                    generated_doc.add_paragraph(f"{one_description}", style='List Bullet')
        generated_doc.save(generated_filename)
        print("Generate long cv: done.")
        convert(generated_filename, generated_filename.replace(".docx", ".pdf"))
        print("Long cv saved as PDF: done.")


def format_publication(document, publi):
    paragraph_item_publi = document.add_paragraph(style='List Number') # numbered list

    # publication authors
    i = 1
    if "main_author" in publi:
        main_author = publi["main_author"]
    else:
        main_author = False
    for author in publi["authors"]:
        run_one_author = paragraph_item_publi.add_run()
        first, last = author["first"], author["last"]
        run_one_author.add_text(f"{first} {last}")
        run_one_author_comma = paragraph_item_publi.add_run()
        # author is a JSON with two fields: first and last names
        if i == len(publi["authors"]):
            # last author
            run_one_author_comma.add_text(f". ")
            if main_author:
                run_one_author.underline = True
                main_author = False
        else:
            run_one_author_comma.add_text(", ")
            if main_author:
                run_one_author.underline = True
                main_author = False
        i += 1

    # publication title
    if "url" in publi:
        add_hyperlink(paragraph_item_publi, f"{publi["title"]}", publi["url"], True)
        run_title = paragraph_item_publi.add_run()
        run_title.add_text(f". ")
    else:
        run_title = paragraph_item_publi.add_run()
        run_title.add_text(f"{publi["title"]}. ")
        run_title.bold = True

    # publication venue
    run_venue = paragraph_item_publi.add_run()
    run_venue.add_text(f"{publi["venue"]}. ")
    run_venue.italic = True

    # publication year
    run_year = paragraph_item_publi.add_run()
    run_year.add_text(f"{publi["year"]}.")
    return paragraph_item_publi


if __name__ == "__main__":
    generate_long_cv("empty-doc-with-styles.docx", "https://nelly-barret.github.io/data/data.json", "cv-long-nelly-barret.docx")