document.getElementById('addFiles').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('addFilesSection').classList.remove('hidden');
    document.getElementById('pendingApprovalSection').classList.add('hidden');
    document.getElementById('approvedFilesSection').classList.add('hidden');
    document.getElementById('rejectedFilesSection').classList.add('hidden');
    setActiveLink('addFiles');
});

document.getElementById('pendingApproval').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('pendingApprovalSection').classList.remove('hidden');
    document.getElementById('addFilesSection').classList.add('hidden');
    document.getElementById('approvedFilesSection').classList.add('hidden');
    document.getElementById('rejectedFilesSection').classList.add('hidden');
    setActiveLink('pendingApproval');
});

document.getElementById('approvedFiles').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('approvedFilesSection').classList.remove('hidden');
    document.getElementById('addFilesSection').classList.add('hidden');
    document.getElementById('pendingApprovalSection').classList.add('hidden');
    document.getElementById('rejectedFilesSection').classList.add('hidden');
    setActiveLink('approvedFiles');
});

document.getElementById('rejectedFiles').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('rejectedFilesSection').classList.remove('hidden');
    document.getElementById('addFilesSection').classList.add('hidden');
    document.getElementById('pendingApprovalSection').classList.add('hidden');
    document.getElementById('approvedFilesSection').classList.add('hidden');
    setActiveLink('rejectedFiles');
});

document.getElementById('logout').addEventListener('click', function(event) {
    alert("Logging Out....");
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


$(document).ready(function() {
    $("#example").DataTable();
  });