<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยกเลิกการจองคิว | อ่านได้สบายด้วย</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header class="main-header">
        <div class="header-container">
            <div class="brand-logo" onclick="location.href='home.php'" style="cursor: pointer;">
                <span class="logo-icon">📚</span>
                <span class="brand-name">อ่านได้สบายด้วย</span>
            </div>
            <nav class="header-nav" style="display: flex; align-items: center; gap: 20px;">
                <a href="status.php" style="text-decoration: none; color: #2b6cb0; font-weight: bold; background: #ebf8ff; padding: 8px 16px; border-radius: 6px; font-size: 14px;">📊 สถานะจองคิว</a>
                <span class="status-indicator">● ONLINE</span>
            </nav>
        </div>
    </header>

    <div class="body-center-container" style="min-height: calc(100vh - 140px); display: flex; align-items: center; justify-content: center; padding: 20px;">
        <main class="booking-card" style="border-top: 5px solid #e53e3e; max-width: 500px; width: 100%;">
            <div class="card-header">
                <h2 style="color: #c53030;">❌ ยกเลิกการจองคิว</h2>
                <p>กรอกข้อมูลด้านล่างเพื่อทำการยืนยันการยกเลิกคิวของคุณ</p>
            </div>

            <form id="cancelBookingForm">
                <div class="inputs-wrapper-box" style="display: flex; flex-direction: column; gap: 15px;">
                    <div class="form-group" style="display: flex; flex-direction: column; text-align: left;">
                        <label style="font-weight: bold; margin-bottom: 5px; color: #4a5568;">รหัสนักศึกษา</label>
                        <input type="text" name="student_id" placeholder="กรอกรหัสนักศึกษา 10 หลัก" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 15px;">
                    </div>
                    <div class="form-group" style="display: flex; flex-direction: column; text-align: left;">
                        <label style="font-weight: bold; margin-bottom: 5px; color: #4a5568;">รหัสคิวลับ (Booking Code)</label>
                        <input type="text" name="booking_code" placeholder="ตัวอย่าง: ITB-1234" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 15px;">
                    </div>
                </div>

                <button type="submit" style="width: 100%; margin-top: 25px; padding: 12px; background-color: #e53e3e; color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 6px rgba(229, 62, 62, 0.2); transition: 0.2s;">ยืนยันการยกเลิกคิว</button>
            </form>

            <div style="margin-top: 20px; text-align: center;">
                <a href="index.php" style="color: #3182ce; text-decoration: none; font-size: 14px;">← กลับไปหน้าจองคิว</a>
            </div>
        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>