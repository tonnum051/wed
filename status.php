<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตารางสถานะการจองคิววันนี้ | อ่านได้สบายด้วย</title>
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
                <a href="index.php">➕ จองคิวใหม่</a>
                <span class="status-indicator">● ONLINE</span>
            </nav>
        </div>
    </header>

    <div style="max-width: 1100px; margin: 140px auto 40px auto; padding: 0 20px; min-height: calc(100vh - 250px);">
        <div class="card shadow-sm" style="border-radius: 12px; overflow: hidden; padding: 0;">
            <div class="card-header" style="padding: 20px; color: white; text-align: left;">
                <h3 style="margin: 0; font-size: 22px; display: flex; align-items: center; gap: 10px; font-weight: 600;">
                    📋 ตารางสถานะการจองคิววันนี้
                </h3>
            </div>
            
            <div class="table-responsive" style="background: #fcf9f2 !important; padding: 25px; border-radius: 0 0 12px 12px; overflow-x: auto; margin-bottom: 0;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 15px;">
                    <thead>
                        <tr style="background-color: #f3ede0; border-bottom: 2px solid #dfd5c2;">
                            <th style="padding: 16px; color: #1b3322; font-weight: 700;">รหัสคิว</th>
                            <th style="padding: 16px; color: #1b3322; font-weight: 700;">ชื่อผู้จอง</th>
                            <th style="padding: 16px; color: #1b3322; font-weight: 700;">บริการที่จอง</th>
                            <th style="padding: 16px; color: #1b3322; font-weight: 700;">วันที่</th>
                            <th style="padding: 16px; color: #1b3322; font-weight: 700;">เวลา</th>
                            <th style="padding: 16px; color: #1b3322; font-weight: 700;">สถานะ</th>
                        </tr>
                    </thead>
                    <tbody id="historyTableBody" style="color: #1b3322 !important;">
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 40px; color: #1b3322; font-size: 16px; font-weight: 600;">
                                ⏳ กำลังโหลดข้อมูลประวัติคิวจากระบบ...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div style="margin-top: 35px; text-align: center;">
            <a href="cancel.php" class="btn-cancel-link" style="font-size: 15px; font-weight: bold; transition: 0.2s; display: inline-block;">
                💔 ต้องการยกเลิกคิวรับบริการ? คลิกที่นี่เพื่อไปหน้ายกเลิก
            </a>
        </div>
    </div>

    <script src="js/app.js"></script>
</body>
</html>