<style>
    .preview-image {
        width: 200px; /* Set the desired width for the images */
        height: 200px; /* Set the desired height for the images */
        object-fit: cover; /* Maintain aspect ratio and cover the container */
        margin: 10px; /* Add some space between each image and its title input */
        display: inline-block; /* Display images and inputs in a row */
    }

    .image-with-title {
        text-align: center; /* Center-align the contents (image and input) */
    }

    .image-with-title input[type="text"] {
        width: 100%; /* Make the input field take full width of the container */
    }
</style>

<style>
    th , td{
        text-align: center;
    }
</style>

<style>
    .modal-backdrop.in {
        filter: alpha(opacity=50);
        opacity: 0;
    }
</style>

<style>
    /* Add this style to your CSS or in a style tag in your HTML */
    .image-with-title input[type="text"] {
        width: 50%;
        margin: 0px 0px 0px  25% ;
    }
    .imageTitle{
        width: 20%;
        height: 30%;
    }
</style>

<style>
    * {
        box-sizing: border-box;
    }

    .slider {
        width: 300px;
        text-align: center;
        overflow: hidden;
    }

    .slides {
        display: flex;

        overflow-x: auto;
        scroll-snap-type: x mandatory;



        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;

        /*
        scroll-snap-points-x: repeat(300px);
        scroll-snap-type: mandatory;
        */
    }
    .slides::-webkit-scrollbar {
        width: 10px;
        height: 10px;
    }
    .slides::-webkit-scrollbar-thumb {
        background: black;
        border-radius: 10px;
    }
    .slides::-webkit-scrollbar-track {
        background: transparent;
    }
    .slides > div {
        scroll-snap-align: start;
        flex-shrink: 0;
        width: 300px;
        height: 300px;
        margin-right: 50px;
        border-radius: 10px;
        background: #eee;
        transform-origin: center center;
        transform: scale(1);
        transition: transform 0.5s;
        position: relative;

        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 100px;
    }
    .slides > div:target {
        /*   transform: scale(0.8); */
    }
    .author-info {
        background: rgba(0, 0, 0, 0.75);
        color: white;
        padding: 0.75rem;
        text-align: center;
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        margin: 0;
    }
    .author-info a {
        color: white;
    }
    img {
        object-fit: cover;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

    .slider > a {
        display: inline-flex;
        width: 1.5rem;
        height: 1.5rem;
        background: white;
        text-decoration: none;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 0 0.5rem 0;
        position: relative;
    }
    .slider > a:active {
        top: 1px;
    }
    .slider > a:focus {
        background: #000;
    }

    /* Don't need button navigation */
    @supports (scroll-snap-type) {
        .slider > a {
            display: none;
        }
    }

    html, body {
        height: 100%;
        overflow: hidden;
    }


</style>
