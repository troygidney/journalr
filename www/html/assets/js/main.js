// Need to organize

async function load() {

    var calendarEl = document.getElementById('calendar');

    var calendarVar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'MTC',
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        // height: (document.getElementById("sidebarWrapper").offsetHeight),
        contentHeight: "auto",
        headerToolbar: {
            center: 'dayGridMonth,timeGridWeek'
        }, // buttons for switching between views
    });

    calendarVar.render(); //Init render for calendar

    const editorVar = await new EditorJS({
        holder: 'editorjs',
        logLevel: 'ERROR',
        tools: {
            header: {
                class: Header,
                inlineToolbar: true,
                shortcut: 'CMD+SHIFT+H'
            },
            image: SimpleImage,
            checklist: {
                class: Checklist,
                inlineToolbar: true,
            },
            list: {
                class: List,
                inlineToolbar: true,
                config: {
                    defaultStyle: 'unordered'
                }
            },
            embed: {
                class: Embed,
                inlineToolbar: true
            },
            quote: {
                class: Quote,
                inlineToolbar: true,
                shortcut: 'CMD+SHIFT+O',
                config: {
                    quotePlaceholder: 'Enter a quote',
                    captionPlaceholder: 'Quote\'s author',
                }
            }
        }
    });

    // Temp disabling load function to sort saving  
    // let date = new Date().toString("yyyyMMdd");
    // $.ajax({
    //     url: 'auth/load.php',
    //     type: 'POST',
    //     data: {
    //         date: date
    //     },
    //     success: function(msg, status, xhr) {
    //         console.log(msg);
    //         let encoded = msg != "" ? JSON.parse(msg) : null;

    //         editorVar.render(encoded);
    //     },
    //     error: function(err) {
    //         console.log(err);
    //     }
    // });



    let remoteHash;
    let localHash;

    setInterval(function() {
        var dateElement = document.getElementById("navDate");
        dateElement.innerText = new Intl.DateTimeFormat('en-CA', {
            dateStyle: 'full',
            timeStyle: 'long',
            timeZone: 'America/Edmonton'
        }).format(new Date().getTime());
    }, 1000);

    setInterval(function() { //Increase save time, add saves to onchange

        editor.save().then((data) => {
                if (data.blocks.length == 0) {
                    return
                } else {
                    localHash = sha256(JSON.stringify(data.blocks));

                    localHash.then((hash) => {
                        if (hash == remoteHash) return;



                        $.ajax({
                            url: 'auth/save.php',
                            type: 'POST',
                            data: {
                                data: btoa(data)
                            },
                            success: function(msg) {
                                remoteHash = msg;

                                console.log(hash + "<br>" + JSON.stringify(data.blocks));
                                console.log(remoteHash);
                            }
                        });
                    })
                }
            })
            .catch((error) => {
                return;
            })
    }, 3000);

    setInterval(function() {
        $.ajax({
            url: 'auth/heartbeat.php',
            type: 'POST',
            success: function(msg, status, xhr) {},
            error: function(err) {
                window.location.replace("/auth/login.php");
            }
        });
    }, 60000)

    resizeListener();


    return [editorVar, calendarVar];
}


function resizeListener() { // TODO Make this more dynamic
    window.addEventListener("resize", (event) => {
        if (window.innerWidth <= 796 && document.getElementById("sidebar").classList.contains("sideBarChange")) {
            document.getElementById("main").classList.add("mainHidden");
            navToggle(document.getElementById("navHamburger"));
        } else {
            document.getElementById("main").classList.remove("mainHidden");
        }
        console.log(window.innerWidth);
    });
}

function navToggle(element) {
    element.classList.toggle("change");
    document.getElementById("sidebar").classList.toggle("sideBarChange");
    document.getElementById("sidebar").classList.toggle("sideBarHidden");

    document.getElementById("calendar").style.visability = "hidden";
    setTimeout(function() {
        document.getElementById("calendar").style.visability = "visible";
        console.log("render!");
        calendar.updateSize();
    }, 400);

    if (window.innerWidth <= 796)
        document.getElementById("main").classList.toggle("mainHidden");

}

async function sha256(message) {
    // encode as UTF-8
    const msgBuffer = new TextEncoder().encode(message);

    // hash the message
    const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);

    // convert ArrayBuffer to Array
    const hashArray = Array.from(new Uint8Array(hashBuffer));

    // convert bytes to hex string                  
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
}