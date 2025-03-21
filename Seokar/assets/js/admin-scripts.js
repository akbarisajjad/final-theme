document.addEventListener("DOMContentLoaded", function () {
    console.log("Admin scripts loaded for Seokar theme!");

    // 🎨 تغییر رنگ‌بندی قالب به‌صورت زنده
    const colorPicker = document.querySelector('input[name="seokar_primary_color"]');
    if (colorPicker) {
        colorPicker.addEventListener("input", function () {
            document.body.style.setProperty("--seokar-primary-color", this.value);
        });
    }

    // 🌙 مدیریت نمایش تنظیمات مربوط به حالت تاریک
    const darkModeCheckbox = document.querySelector('input[name="seokar_enable_dark_mode"]');
    if (darkModeCheckbox) {
        darkModeCheckbox.addEventListener("change", function () {
            if (this.checked) {
                document.body.classList.add("dark-mode-active");
            } else {
                document.body.classList.remove("dark-mode-active");
            }
        });
    }

    // ✅ بررسی و هشدار هنگام ذخیره تنظیمات
    const settingsForm = document.querySelector("form");
    if (settingsForm) {
        settingsForm.addEventListener("submit", function (event) {
            const logoInput = document.querySelector('input[name="seokar_logo"]').value;
            if (logoInput.trim() === "") {
                event.preventDefault();
                alert("⚠ لطفاً آدرس لوگوی سایت را وارد کنید!");
            }
        });
    }

    // 🔔 نمایش پیام سفارشی بعد از ذخیره تنظیمات
    const settingsUpdated = new URLSearchParams(window.location.search).has("settings-updated");
    if (settingsUpdated) {
        const notice = document.createElement("div");
        notice.className = "notice notice-success is-dismissible";
        notice.innerHTML = "<p>✅ تنظیمات قالب با موفقیت ذخیره شد.</p>";
        document.querySelector(".wrap h1").after(notice);
    }

    // 🔄 نمایش پیش‌نمایش آپلود لوگو
    const logoInput = document.querySelector('input[name="seokar_logo"]');
    if (logoInput) {
        const preview = document.createElement("img");
        preview.style.maxWidth = "150px";
        preview.style.display = "block";
        preview.style.marginTop = "10px";
        if (logoInput.value) {
            preview.src = logoInput.value;
        }
        logoInput.parentNode.appendChild(preview);

        logoInput.addEventListener("input", function () {
            preview.src = this.value;
        });
    }
});
