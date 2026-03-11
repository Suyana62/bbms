function toggleDropdown() {
    const dropdown = document.getElementById('notifDropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

window.onclick = function(event) {
    if (!event.target.closest('.notify')) {
        document.getElementById('notifDropdown').style.display = 'none';
    }
}
