<?php
/*** set the content type header ***/
/*** Without this header, it wont work ***/
header("Content-type: text/css");


$font_family = 'Arial, Helvetica, sans-serif';
$font_size = '0.7em';
$border = '1px solid';
?>
/* General Styles */
body {
    font-family: 'Georgia', serif;
    color: #333;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    line-height: 1.6;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container */
.container {
    background: white;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 90%;
    border: 1px solid #ddd;
    text-align: center;
    animation: fadeIn 1s ease-in-out;
}

.container h2 {
    font-size: 2em;
    color: #495057;
    margin-bottom: 10px;
}

.container p {
    font-size: 0.9em;
    color: #555;
    margin-bottom: 20px;
}

/* Form */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

form label {
    align-self: flex-start;
    margin: 10px 0 5px;
    font-weight: bold;
    color: #495057;
}

form input {
    width: 100%;
    padding: 10px;
    margin: 5px 0 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    font-size: 1em;
    transition: border 0.3s ease;
}

form input:focus {
    border-color: #6c757d;
    outline: none;
    box-shadow: 0 0 5px rgba(108, 117, 125, 0.5);
}

form button {
    background-color: #343a40;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    font-weight: bold;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    margin-top: 10px;
    width: 100%;
}

form button:hover {
    background-color: #495057;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}

/* Error and Success Messages */
#error-message, #eMessage, #sMessage {
    color: red;
    font-size: 0.9em;
    margin: 10px 0;
}
#sMessage {
    color: green;
}

/* Link */
.container a {
    color: #6c757d;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

.container a:hover {
    color: #495057;
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        padding: 20px;
    }
}
