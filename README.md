# STLWD

## Sidebars and Buttons
My task is to create sideabars and buttons 


## Description
- Infor button on the top left screen to allow user to see more about the info and purpose of the app. 
- Map details button on the top right screen where user can add their new map, images, text into our system. 
- Once user click on any button a left side bar view or bottom side bar view should appear respectively. Within these side bar view we would need an extra button to let user to hide the view if they no long want to see it. With the bottom side view, this is where user able to insert their map as well as information, we should be able to see the form input as well as the button for them to submit the input.

- Setup 2 buttons html component and place them within 2 separate div inside a flex box div where we could specify one on the left and one on the right side of the screen.
- Implement 2 new views that act as side view bar, one for information and one for user map input placeholder.
- Add some css styling to allow the side view bar display smoothly.
- Setup a new Js helper function that associated with the 2 buttons from the first step. This helper function take in an parameter to tell whether the button is belongs to information or user placeholder map. Within the function, user the parameter and check which view to display.
- For each side view components, add another X button and place them on the top of the view. This button should associate to another js function to close or hide the side view
- For the user placeholder map side view, beside of the form input, we need another button and place them at the bottom of the side view. Once client clicked, we should able to be grab data from the form placeholder and send a post request to our system.
