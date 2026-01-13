document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".date-picker").forEach(wrapper => {
        initDatePicker(wrapper);
    });

    function initDatePicker(wrapper) {
        const input = wrapper.querySelector(".date-input");
        const calendar = wrapper.querySelector(".calendar");

        if (!input || !calendar) return;

        let today = new Date();
        today.setHours(0, 0, 0, 0);

        let month = today.getMonth();
        let year = today.getFullYear();

        input.addEventListener("click", (e) => {
            e.stopPropagation();
            calendar.style.display = "block";
            renderCalendar();
        });

        calendar.addEventListener("click", (e) => {
            e.stopPropagation();
        });

        document.addEventListener("click", (e) => {
            if (!wrapper.contains(e.target)) {
                calendar.style.display = "none";
            }
        });

        function renderCalendar() {
            calendar.innerHTML = "";

            const header = document.createElement("div");
            header.className = "calendar-header";

            const prev = document.createElement("button");
            prev.type = "button";
            prev.innerHTML = "&lt;";
            prev.onclick = (e) => {
                e.stopPropagation();
                month--;
                adjustMonth();
            };

            const next = document.createElement("button");
            next.type = "button";
            next.innerHTML = "&gt;";
            next.onclick = (e) => {
                e.stopPropagation();
                month++;
                adjustMonth();
            };

            const title = document.createElement("span");
            title.textContent = new Date(year, month).toLocaleString("default", {
                month: "long",
                year: "numeric"
            });

            header.append(prev, title, next);
            calendar.appendChild(header);

            const weekdays = document.createElement("div");
            weekdays.className = "calendar-weekdays";
            ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"].forEach(day => {
                const d = document.createElement("div");
                d.textContent = day;
                weekdays.appendChild(d);
            });
            calendar.appendChild(weekdays);

            const days = document.createElement("div");
            days.className = "calendar-days";

            const firstDay = new Date(year, month, 1).getDay();
            const totalDays = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                days.appendChild(document.createElement("div"));
            }

            for (let d = 1; d <= totalDays; d++) {
                const day = document.createElement("div");
                day.textContent = d;

                const selectedDate = new Date(year, month, d);
                selectedDate.setHours(0, 0, 0, 0);

                if (selectedDate < today) {
                    day.classList.add("disabled");
                    days.appendChild(day);
                    continue;
                }

                day.onclick = () => {
                    input.value =
                        `${year}-${String(month + 1).padStart(2, "0")}-${String(d).padStart(2, "0")}`;
                    calendar.style.display = "none";
                };

                days.appendChild(day);
            }

            calendar.appendChild(days);
        }

        function adjustMonth() {
            if (month < 0) {
                month = 11;
                year--;
            }
            if (month > 11) {
                month = 0;
                year++;
            }
            renderCalendar();
        }
    }

});


document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.password-toggle');
    
    toggles.forEach(toggle => {
        const input = document.getElementById(toggle.getAttribute('data-target'));
        const eyeShow = toggle.querySelector('.eye-show');
        const eyeHide = toggle.querySelector('.eye-hide');

   
        eyeShow.style.display = 'inline';
        eyeHide.style.display = 'none';

        toggle.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text';        
                eyeShow.style.display = 'none';
                eyeHide.style.display = 'inline';
            } else {
                input.type = 'password';    
                eyeShow.style.display = 'inline';
                eyeHide.style.display = 'none';
            }
        });
    });
});
function initPasswordToggle(modalSelector) {
  $(modalSelector).find('.password-toggle').each(function() {
    const toggle = $(this);
    const input = toggle.siblings('input'); 
    const eyeShow = toggle.find('.eye-show');
    const eyeHide = toggle.find('.eye-hide');

    eyeShow.show();
    eyeHide.hide();

    toggle.off('click').on('click', function() {
      if(input.attr('type') === 'password') {
        input.attr('type', 'text');
        eyeShow.hide();
        eyeHide.show();
      } else {
        input.attr('type', 'password');
        eyeShow.show();
        eyeHide.hide();
      }
    });
  });
}



