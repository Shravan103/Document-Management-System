document.getElementById('fileManagement').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('fileManagementSection').classList.remove('hidden');
    document.getElementById('StarredSection').classList.add('hidden');
    setActiveLink('fileManagement');
});

document.getElementById('Starred').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('StarredSection').classList.remove('hidden');
    document.getElementById('fileManagementSection').classList.add('hidden');
    setActiveLink('Starred');
});

document.getElementById('logout').addEventListener('click', function(event) {
    alert("Logging Out");
});

function setActiveLink(activeLinkId) {
    const links = document.querySelectorAll('.sidebar a');
    links.forEach(link => {
        if (link.id === activeLinkId) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
}


document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("fileManagement").addEventListener("click", function() {
        document.getElementById("fileManagementSection").classList.remove("hidden");
        document.getElementById("StarredSection").classList.add("hidden");
    });
    
    document.getElementById("Starred").addEventListener("click", function() {
        document.getElementById("fileManagementSection").classList.add("hidden");
        document.getElementById("StarredSection").classList.remove("hidden");
    });

    $('#myTable').DataTable();
    $('#starredTable').DataTable();
});


document.getElementById('fileManagement').addEventListener('click', function() {
    document.getElementById('fileManagementSection').classList.remove('hidden');
    document.getElementById('StarredSection').classList.add('hidden');
});

document.getElementById('Starred').addEventListener('click', function() {
    document.getElementById('fileManagementSection').classList.add('hidden');
    document.getElementById('StarredSection').classList.remove('hidden');
});
