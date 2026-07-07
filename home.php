<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>อ่านได้สบายด้วย | หน้าหลัก</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* 🎨 CSS เพิ่มเติมสำหรับ Section ห้องนั่งอ่านและ Footer ท้ายเว็บ */
        .library-rooms-section {
            background-color: #111111; /* พื้นหลังสไลด์ล่างเป็นสีดำ */
            color: #ffffff;
            padding: 80px 20px;
            text-align: center;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 50px;
            color: #fcf9f2;
            letter-spacing: 0.5px;
        }

        .rooms-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 50px;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .room-card {
            flex: 1;
            min-width: 250px;
            max-width: 320px;
            text-align: center;
        }

        /* 🔴 วงกลมของรูปภาพ */
        .image-wrapper {
            width: 220px;
            height: 220px;
            margin: 0 auto 25px auto;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #1b3322;
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
            transition: all 0.4s ease;
            position: relative;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.4s ease;
        }

        /* ✨ เอฟเฟกต์เมื่อเอาเมาส์ชี้ภาพ: รูปขยายขึ้น และเรืองแสง */
        .room-card:hover .image-wrapper {
            border-color: #dfd5c2;
            box-shadow: 0 0 25px rgba(223, 213, 194, 0.7);
            transform: translateY(-5px);
        }

        .room-card:hover .image-wrapper img {
            transform: scale(1.1);
        }

        /* 📋 คอนเทนเนอร์แสดงข้อมูลใต้ภาพ */
        .room-info {
            overflow: hidden; /* บังคับให้ตัวอักษรที่สไลด์มาจากนอกขอบซ้ายมองไม่เห็น */
            position: relative;
            padding-top: 10px;
            min-height: 80px;
        }

        .room-name {
            font-size: 20px;
            font-weight: 600;
            color: #dfd5c2;
            margin: 0 0 8px 0;
        }

        /* 🌠 เอฟเฟกต์ตัวอักษรโผล่ขึ้นมาจากซ้ายไปขวา (Slide from Left to Right) */
        .room-description {
            font-size: 14px;
            color: #a0aec0;
            margin: 0;
            line-height: 1.5;
            transform: translateX(-100%); /* เริ่มต้นดันออกไปทางซ้ายสุดจนลับสายตา */
            opacity: 0;
            transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.4s ease;
        }

        /* เมื่อเอาเมาส์ชี้ที่การ์ดห้อง ให้ตัวอักษรสไลด์กลับมาตำแหน่งเดิมตรงกลาง */
        .room-card:hover .room-description {
            transform: translateX(0);
            opacity: 1;
        }

        /* 🌿 Footer ด้านล่างสุดสีเขียวเข้ม */
        .main-footer {
            background-color: #1b3322; /* สีเขียวเข้มเดียวกับแบรนด์ */
            color: #fcf9f2;
            padding: 30px 20px;
            border-top: 1px solid #24422c;
            text-align: center;
        }

        .footer-container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .footer-credit {
            font-size: 13px;
            color: #dfd5c2;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }

        .developers-grid {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .dev-name {
            font-size: 14px;
            font-weight: 600;
            background: rgba(253, 249, 242, 0.1);
            padding: 6px 16px;
            border-radius: 20px;
            border: 1px solid rgba(223, 213, 194, 0.2);
            color: #fcf9f2;
        }
    </style>
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh; margin:0; padding:0;">

    <header class="main-header" style="position: static;">
        <div class="header-container">
            <div class="brand-logo" onclick="location.href='home.php'" style="cursor: pointer;">
                <span class="logo-icon">🌿</span>
                <span class="brand-name">อ่านได้สบายด้วย</span>
            </div>
            <nav class="header-nav" style="display: flex; align-items: center; gap: 20px;">
                <a href="status.php" class="btn-status" style="text-decoration: none; font-size: 14px;">📊 สถานะจองคิว</a>
                <span class="status-indicator">● ONLINE</span>
            </nav>
        </div>
    </header>

    <div style="background: linear-gradient(rgba(27, 51, 34, 0.85), rgba(27, 51, 34, 0.85)), url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=1200') no-repeat center center/cover; padding: 100px 40px; text-align: left; display: flex; justify-content: center; align-items: center;">
        <div style="max-width: 1200px; width: 100%; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 40px;">
            <div style="flex: 1; min-width: 300px; color: white;">
                <h1 style="font-size: 42px; font-weight: 700; margin-bottom: 20px; color: #fcf9f2;">อ่านได้สบายด้วย</h1>
                <p style="font-size: 16px; color: #dfd5c2; line-height: 1.6; margin-bottom: 35px; max-width: 500px;">
                    ระบบจองคิวเข้าใช้บริการห้องอ่านหนังสืออัจฉริยะ เลือกมุมโปรด เวลาที่ใช่ง่าย ๆ เพื่อให้ชั่วโมงการอ่านของคุณเงียบสงบและสบายใจที่สุด
                </p>
                <a href="index.php" style="display: inline-block; background-color: #fcf9f2; color: #1b3322; padding: 14px 32px; border-radius: 30px; font-weight: 700; text-decoration: none; font-size: 16px; box-shadow: 0 4px 14px rgba(0,0,0,0.2); transition: 0.2s;">
                    จองคิวออนไลน์
                </a>
            </div>
            <div style="flex: 1; min-width: 300px; display: flex; justify-content: center;">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=600" alt="Library Space" style="max-width: 100%; height: auto; border-radius: 16px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);">
            </div>
        </div>
    </div>

    <section class="library-rooms-section">
        <h2 class="section-title">✨ พื้นที่อ่านหนังสือระดับพรีเมียมที่คุณเลือกได้</h2>
        
        <div class="rooms-container">
            <div class="room-card">
                <div class="image-wrapper">
                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?q=80&w=400" alt="Silent Zone">
                </div>
                <div class="room-info">
                    <h4 class="room-name">ห้อง Smart Silent Zone</h4>
                    <p class="room-description">มุมเงียบสงบพิเศษ งดใช้เสียง 100% เหมาะสำหรับการอ่านหนังสือสอบที่ต้องการสมาธิขั้นสูงสุด</p>
                </div>
            </div>

            <div class="room-card">
                <div class="image-wrapper">
                    <img src="https://images.unsplash.com/photo-1568667256549-094345857637?q=80&w=400" alt="Co-Working Space">
                </div>
                <div class="room-info">
                    <h4 class="room-name">ห้อง Creative Lounge</h4>
                    <p class="room-description">พื้นที่สไตล์ Co-Working ผ่อนคลายสบาย ๆ สามารถนั่งทำงานกลุ่ม แลกเปลี่ยนไอเดียได้อย่างอิสระ</p>
                </div>
            </div>

            <div class="room-card">
                <div class="image-wrapper">
                    <img src="https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?q=80&w=400" alt="Private Box">
                </div>
                <div class="room-info">
                    <h4 class="room-name">ห้อง Media & Private Box</h4>
                    <p class="room-description">ตู้กระจกส่วนตัวพร้อมปลั๊กไฟและหน้าจอเชื่อมต่อ สำหรับผู้ที่ต้องการใช้โน้ตบุ๊กหรือค้นคว้าออนไลน์</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="main-footer">
        <div class="footer-container">
            <div class="footer-credit">© 2026 อ่านได้สบายด้วย - ระบบบริหารจัดการคิวห้องสมุดอัจฉริยะ</div>
            <div style="font-size: 12px; color: #a2bca6; font-weight: bold; margin-top: 5px;">💻 คณะผู้จัดทำและพัฒนาโปรแกรม:</div>
            
            <div class="developers-grid">
                <div class="dev-name">สมาชิก:ณัฐชนนท์ เดชขนาด DEV</div>
                <div class="dev-name">สมาชิก:รัชชานนท์ แย้มแสง PM-TEST</div>
                <div class="dev-name">สมาชิก:กฤษณพงศ์ เกตุสระ  UX/UI-SA </div>
                <div class="dev-name">สมาชิก:รุจดนัย เข็มทอง UX/UI-DEV</div>
            </div>
        </div>
    </footer>

</body>
</html>