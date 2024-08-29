<?php
session_start();
$role = $_SESSION['role'];
$file_id = $_GET['Id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
</head>

<style>
    .saveclass {
        border: none;
        display: flex;
        padding: 0.75rem 1.5rem;
        background-color: #488aec;
        color: #ffffff;
        font-size: 0.75rem;
        line-height: 1rem;
        font-weight: 700;
        cursor: pointer;
        text-align: center;
        text-transform: uppercase;
        vertical-align: middle;
        align-items: center;
        border-radius: 0.5rem;
        user-select: none;
        gap: 0.75rem;
        box-shadow: 0 4px 6px -1px #488aec31, 0 2px 4px -1px #488aec17;
        transition: all 0.6s ease;
        float: right;
        width: 120px;
        height: 50px;
    }

    .saveclass:hover {
        box-shadow: 0 10px 15px -3px #488aec4f, 0 4px 6px -2px #488aec17;
    }

    .saveclass:focus,
    .saveclass:active {
        opacity: 0.85;
        box-shadow: none;
    }

    .saveclass svg {
        width: 1.25rem;
        height: 1.25rem;
    }

    .noselect {
        width: 120px;
        height: 50px;
        cursor: pointer;
        display: flex;
        align-items: center;
        background: red;
        border: none;
        border-radius: 5px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        background: #e62222;
        float: right;
        color: #ffffff;
        font-size: 1rem;
        line-height: 1rem;
        font-weight: 700;

    }

    .noselect,
    .noselect span {
        transition: 200ms;
    }

    .noselect .text {
        transform: translateX(35px);
        color: white;
        font-weight: bold;
    }

    .noselect .icon {
        position: absolute;
        border-left: 1px solid #c41b1b;
        transform: translateX(50px);
        height: 40px;
        width: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .noselect svg {
        width: 15px;
        fill: #eee;
    }

    .noselect:hover {
        background: #ff3636;
    }

    .noselect:hover .text {
        color: transparent;
    }

    .noselect:hover .icon {
        width: 100px;
        border-left: none;
        transform: translateX(0);
    }

    .noselect:focus {
        outline: none;
    }

    .noselect:active .icon svg {
        transform: scale(0.8);
    }
    .resizable-textarea {
  resize: both; /* Enables vertical and horizontal resizing */
  overflow: auto; /* Adds a scrollbar when content overflows */
  min-height: 100px; /* Minimum height of the textarea */
}
</style>

<body>
    <div class="container-fluid" id="com">
        <div class="row">
            <div class="col-lg-8 col-md-10 col-sm-12 mx-auto min-auto">
                <div class="theme-setting-wrapper mt-4">
                    <div id="settings-trigger" data-toggle="modal" data-target=".bd-example-modal-lg"><i
                            class="far fa-comment-alt"></i></div>
                    <!-- <i class="settings-close ti-close"></i> -->
                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content p-2">

                                <p class="settings-heading font-weight-bold" id="codcmd"
                                    style="font-family: 'Roboto Slab', sans-serif; font-size: 18px; font-weight: bold; color: #333;">
                                    Comments</p>

                                <div class="form-group" style="float:right">
                                    <button class="noselect" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">Close</span><span class="icon"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z">
                                                </path>
                                            </svg></span></button>
                                    <!-- <button class="btn btn-primary cmd_button mt-2" id="saveComments" style="float:right">Save</button> -->
                                    <button class="cmd_button mr-5 saveclass" id="saveComments">
                                        <svg aria-hidden="true" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z"
                                                stroke-linejoin="round" stroke-linecap="round"></path>
                                        </svg>
                                        Save
                                    </button>
                                </div>
                                <br>
                                <div class="form-group m-3">
                                    <label for="codesegment_cmd" class="">Code Segments</label>
                                    <br>
                                    <textarea
                                        class="form-control resizable-textarea shadow bg-white rounded scrollable-textarea myTextarea"
                                        id="codesegment_cmd" rows="10"
                                        placeholder="Enter your comment here..."></textarea>
                                </div>
                                <br>
                                <div class="form-group m-3">
                                    <label for="oasissegment_cmd" class="">Oasis Segments</label>
                                    <br>
                                    <textarea
                                        class="form-control resizable-textarea shadow bg-white rounded scrollable-textarea myTextarea"
                                        id="oasissegment_cmd" rows="10"
                                        placeholder="Enter your comment here..."></textarea>
                                </div>
                                <br>
                                <?php if ($assessmentType != 'Coding Only Soc') : ?>
                                <div class="form-group m-3">
                                    <label for="poc_cmd" class="">POC Segments</label>
                                    <br>
                                    <textarea
                                        class="form-control shadow resizable-textarea bg-white rounded scrollable-textarea myTextarea"
                                        id="poc_cmd" rows="10" placeholder="Enter your comment here..."></textarea>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="Assign/js/comments.js"></script>

<!--     <script>
        // Get all textareas
        const textareas = document.querySelectorAll('.myTextarea');

        // Add event listener for each textarea
        textareas.forEach(textarea => {
            textarea.addEventListener('keydown', (event) => {
                let cursorPos = textarea.selectionStart;
                let lines = textarea.value;
                let currentLine = textarea.value.substr(0, cursorPos).length - 1;

                // Check which arrow key is pressed
                switch (event.key) {
                    case 'ArrowLeft':
                        if (cursorPos > 0) {
                            textarea.setSelectionRange(cursorPos - 1, cursorPos - 1);
                        }
                        break;
                    case 'ArrowRight':
                        if (cursorPos < textarea.value.length) {
                            textarea.setSelectionRange(cursorPos + 1, cursorPos + 1);
                        }
                        break;
                    case 'ArrowUp':
                        if (currentLine > 0) {
                            let newPos = textarea.value.lastIndexOf('\n', cursorPos - 2);
                            textarea.setSelectionRange(newPos + 1, newPos + 1);
                        }
                        break;
                    case 'ArrowDown':
                        if (currentLine < lines.length - 1) {
                            let newPos = textarea.value.indexOf('\n', cursorPos);
                            if (newPos === -1) {
                                newPos = textarea.value.length;
                            }
                            textarea.setSelectionRange(newPos + 1, newPos + 1);
                        }
                        break;

                    default:
                        break;
                }
            });
        });
    </script> -->
</body>

</html>