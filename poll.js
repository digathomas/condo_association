var polljs = {
    // poll.show() : show/update the poll docket
    // PARAM showRes : force show results (optional)
    show : function(showRes){


        // FETCH DATA
        var data = new FormData();
        data.append('req', "show");
        data.append('poll_id', document.getElementById("poll_id").value);
        if (showRes==1) {
            data.append('show', "1");
        }

        // AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', "lib/poll_handler.php", true);
        xhr.onload = function(){
            document.getElementById("container").innerHTML = this.response;
        };
        xhr.send(data);
    },
    // poll.save() : save the poll vote
    save : function(){


        var selected = document.querySelector('input[name=poll]:checked');
        if (selected==null) {
            alert("Please select an option.");
        } else {
            // FETCH DATA
            var data = new FormData();
            data.append('req', "save");
            data.append('poll_id', document.getElementById("poll_id").value);
            data.append('option_id', selected.value);

            // AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', "lib/poll_handler.php", true);
            xhr.onload = function(){
                if (this.response==="OK") {
                    polljs.show();
                } else {
                    alert("ERROR SAVING VOTE!");
                }
            };
            xhr.send(data);
        }
        return false;
    }
};

window.addEventListener("load", polljs.show);