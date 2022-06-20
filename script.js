const alerts = document.querySelectorAll(".alert");

if (alerts){
    alerts.forEach(alert => {
        setTimeout(() => {alert.style.display = "none"}, 8000);
    });
};