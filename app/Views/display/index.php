<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Publik - QueueBank ProMax</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="<?= base_url('app/Views/layouts/mobile-display.css') ?>" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            min-height: 100vh;
            overflow-x: hidden;
            color: #ffffff;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #7c3aed 100%);
            position: relative;
            overflow: hidden;
            padding: 2rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .header-content {
            position: relative;
            z-index: 10;
            text-align: center;
        }

        .header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.25rem;
            color: #e2e8f0;
            font-weight: 500;
        }

        /* Decorative elements */
        .header-decoration {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            filter: blur(40px);
        }

        .decoration-1 {
            top: -100px;
            left: -100px;
        }

        .decoration-2 {
            bottom: -100px;
            right: -100px;
            background: rgba(124, 58, 237, 0.2);
        }

        /* Main Content */
        .main-content {
            padding: 3rem 0;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        /* Current Queue Card */
        .current-queue {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 32px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .current-queue::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6, #06b6d4);
        }

        .current-queue-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .current-queue-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .current-queue h2 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
        }

        .display-number {
            font-size: 8rem;
            font-weight: 900;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 8px rgba(220, 38, 38, 0.3);
            margin: 1rem 0;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }

        .display-number.animate {
            transform: scale(1.1) rotate(2deg);
        }

        .loket-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            font-size: 2rem;
            font-weight: 600;
            color: #374151;
            margin-top: 1rem;
        }

        .loket-icon {
            color: #3b82f6;
        }

        .service-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #dbeafe, #e0e7ff);
            border-radius: 50px;
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e40af;
            margin-top: 1rem;
        }

        /* Next Queue Card */
        .next-queue {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .next-queue-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .next-queue-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #f59e0b, #f97316);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .next-queue h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
        }

        .queue-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 16px;
            margin-bottom: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
            transition: all 0.3s ease;
        }

        .queue-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .queue-item-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .queue-position {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.875rem;
        }

        .position-1 { background: linear-gradient(135deg, #10b981, #059669); }
        .position-2 { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .position-3 { background: linear-gradient(135deg, #6b7280, #4b5563); }

        .queue-details h4 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .queue-details p {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .queue-status {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-next { background: #dcfce7; color: #166534; }
        .status-waiting { background: #dbeafe; color: #1e40af; }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Clock Card */
        .clock-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .clock-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .clock-icon {
            color: #3b82f6;
        }

        .clock-header h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }

        .clock-time {
            font-size: 2.5rem;
            font-weight: 800;
            font-family: 'Inter', monospace;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .clock-date {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        /* Statistics Card */
        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .stats-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stats-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .stats-header h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        .stat-item-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .stat-item-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.875rem;
        }

        .stat-total { background: linear-gradient(135deg, #dbeafe, #bfdbfe); }
        .stat-total .stat-item-icon { background: #3b82f6; }

        .stat-completed { background: linear-gradient(135deg, #dcfce7, #bbf7d0); }
        .stat-completed .stat-item-icon { background: #10b981; }

        .stat-waiting { background: linear-gradient(135deg, #fef3c7, #fde68a); }
        .stat-waiting .stat-item-icon { background: #f59e0b; }

        .stat-label {
            font-weight: 500;
            color: #374151;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
        }

        .stat-total .stat-value { color: #1e40af; }
        .stat-completed .stat-value { color: #047857; }
        .stat-waiting .stat-value { color: #d97706; }

        /* Running Text */
        .running-text {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #374151, #4b5563);
            color: white;
            padding: 1rem 0;
            overflow: hidden;
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .running-text-content {
            white-space: nowrap;
            animation: scroll-left 30s linear infinite;
            font-size: 1.125rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .running-text-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .running-text-icon {
            color: #60a5fa;
        }

        @keyframes scroll-left {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #d1d5db;
        }

        .empty-state h4 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            font-size: 0.875rem;
        }

        /* Mobile Specific Styles */
        .mobile-header {
            display: none;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #7c3aed 100%);
            padding: 1.5rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .mobile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .mobile-header-content {
            position: relative;
            z-index: 10;
        }

        .mobile-header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .mobile-header-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .mobile-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mobile-header p {
            font-size: 0.875rem;
            color: #e2e8f0;
            font-weight: 500;
        }

        .mobile-header .mode-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            margin-top: 0.75rem;
            font-size: 0.75rem;
            color: #e2e8f0;
        }

        .mobile-info-cards {
            display: none;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-info-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-info-card .value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .mobile-info-card .label {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 500;
        }

        .mobile-service-cards {
            display: none;
            flex-direction: column;
            gap: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-service-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        .mobile-service-card h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .mobile-service-card p {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .mobile-service-card .prefix {
            display: inline-block;
            background: linear-gradient(135deg, #dbeafe, #e0e7ff);
            color: #1e40af;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .mobile-bottom-bar {
            display: none;
            background: #6b7280;
            color: white;
            padding: 1rem;
            text-align: center;
            border-radius: 16px 16px 0 0;
            margin: 0 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .display-number {
                font-size: 6rem;
            }
            
            .header h1 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .current-queue,
            .next-queue,
            .clock-card,
            .stats-card {
                padding: 1.5rem;
            }
            
            .display-number {
                font-size: 4rem;
            }
            
            .loket-info {
                font-size: 1.5rem;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }

        /* Mobile First Responsive Design */
        @media (max-width: 480px) {
            /* Hide desktop elements on mobile */
            .header,
            .main-content,
            .running-text {
                display: none;
            }

            /* Show mobile elements */
            .mobile-header {
                display: block;
            }

            .mobile-info-cards {
                display: grid;
            }

            .mobile-service-cards {
                display: flex;
            }

            .mobile-bottom-bar {
                display: block;
            }

            /* Mobile specific layout */
            body {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
                padding-bottom: 0;
            }

            .mobile-container {
                padding: 0;
            }

            /* Mobile info cards styling */
            .mobile-info-card .value {
                font-size: 1.25rem;
            }

            .mobile-info-card .label {
                font-size: 0.7rem;
            }

            /* Mobile service cards styling */
            .mobile-service-card {
                padding: 1.25rem;
            }

            .mobile-service-card h3 {
                font-size: 1rem;
            }

            .mobile-service-card p {
                font-size: 0.8rem;
            }

            .mobile-service-card .prefix {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
        }

        /* Mobile First Responsive Design */
        @media (max-width: 480px) {
            /* Hide desktop elements on mobile */
            .header,
            .main-content,
            .running-text {
                display: none;
            }

            /* Show mobile elements */
            .mobile-header {
                display: block;
            }

            .mobile-info-cards {
                display: grid;
            }

            .mobile-service-cards {
                display: flex;
            }

            .mobile-bottom-bar {
                display: block;
            }

            /* Mobile specific layout */
            body {
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
                padding-bottom: 0;
            }

            .mobile-container {
                padding: 0;
            }

            /* Mobile info cards styling */
            .mobile-info-card .value {
                font-size: 1.25rem;
            }

            .mobile-info-card .label {
                font-size: 0.7rem;
            }

            /* Mobile service cards styling */
            .mobile-service-card {
                padding: 1.25rem;
            }

            .mobile-service-card h3 {
                font-size: 1rem;
            }

            .mobile-service-card p {
                font-size: 0.8rem;
            }

            .mobile-service-card .prefix {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
        }

        /* Mobile Specific Styles */
        .mobile-header {
            display: none;
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #7c3aed 100%);
            padding: 1.5rem 1rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .mobile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .mobile-header-content {
            position: relative;
            z-index: 10;
        }

        .mobile-header-title {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .mobile-header-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .mobile-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #ffffff 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mobile-header p {
            font-size: 0.875rem;
            color: #e2e8f0;
            font-weight: 500;
        }

        .mobile-header .mode-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            margin-top: 0.75rem;
            font-size: 0.75rem;
            color: #e2e8f0;
        }

        .mobile-info-cards {
            display: none;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-info-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .mobile-info-card .value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .mobile-info-card .label {
            font-size: 0.75rem;
            color: #6b7280;
            font-weight: 500;
        }

        .mobile-service-cards {
            display: none;
            flex-direction: column;
            gap: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-service-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-align: center;
        }

        .mobile-service-card h3 {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .mobile-service-card p {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .mobile-service-card .prefix {
            display: inline-block;
            background: linear-gradient(135deg, #dbeafe, #e0e7ff);
            color: #1e40af;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .mobile-bottom-bar {
            display: none;
            background: #6b7280;
            color: white;
            padding: 1rem;
            text-align: center;
            border-radius: 16px 16px 0 0;
            margin: 0 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
    </style>
</head>
<body>
    <!-- Desktop Header -->
    <header class="header">
        <div class="header-decoration decoration-1"></div>
        <div class="header-decoration decoration-2"></div>
        <div class="container">
            <div class="header-content">
                <div class="header-title">
                    <div class="header-icon">
                        <i class="fas fa-building" style="font-size: 1rem; color: white;"></i>
                    </div>
                    <div>
                        <h1>QueueBank ProMax</h1>
                        <p><i class="fas fa-bolt" style="color: #fbbf24; margin-right: 0.5rem;"></i>Sistem Antrian Digital Terdepan</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Header -->
    <header class="mobile-header">
        <div class="mobile-header-content">
            <div class="mobile-header-title">
                <div class="mobile-header-icon">
                    <i class="fas fa-ticket-alt" style="font-size: 1rem; color: white;"></i>
                </div>
                <div>
                    <h1>MESIN ANTRIAN</h1>
                    <p>Silakan pilih kategori layanan dan ambil nomor antrian</p>
                    <div class="mode-indicator">
                        <i class="fas fa-mobile-alt"></i>
                        <span>Mobile Mode</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Info Cards -->
    <div class="mobile-info-cards">
        <div class="mobile-info-card">
            <div class="value" id="mobileTotalAntrian">41</div>
            <div class="label">Total Antrian</div>
        </div>
        <div class="mobile-info-card">
            <div class="value" id="mobileSedangDipanggil">0</div>
            <div class="label">Sedang Dipanggil</div>
        </div>
        <div class="mobile-info-card">
            <div class="value" id="mobileSedangMenunggu">-</div>
            <div class="label">Sedang Menunggu</div>
        </div>
        <div class="mobile-info-card">
            <div class="value" id="mobileUpdateTerakhir">22.40.48</div>
            <div class="label">Update Terakhir</div>
        </div>
    </div>

    <!-- Mobile Service Cards -->
    <div class="mobile-service-cards">
        <div class="mobile-service-card">
            <h3>Teller</h3>
            <p>Layanan teller untuk transaksi perbankan</p>
            <div class="prefix">Prefix: A</div>
        </div>
        <div class="mobile-service-card">
            <h3>Customer Service</h3>
            <p>Layanan customer service untuk informasi dan konsultasi</p>
            <div class="prefix">Prefix: B</div>
        </div>
        <div class="mobile-service-card">
            <h3>Prioritas</h3>
            <p>Layanan prioritas untuk nasabah prioritas</p>
            <div class="prefix">Prefix: C</div>
        </div>
    </div>

    <!-- Mobile Bottom Bar -->
    <div class="mobile-bottom-bar">
        Pilih kategori terlebih dahulu
    </div>

    <!-- Desktop Main Content -->
    <main class="container">
        <div class="main-content">
            <!-- Left Column -->
            <div>
                <!-- Current Queue -->
                <div class="current-queue fade-in">
                    <div class="current-queue-header">
                        <div class="current-queue-icon">
                            <i class="fas fa-tv"></i>
                        </div>
                        <h2>Nomor Antrian yang Dipanggil</h2>
                    </div>
                    
                    <div class="display-number" id="currentNumber">-</div>
                    
                    <div class="loket-info" id="currentLoket" style="display: none;">
                        <i class="fas fa-map-marker-alt loket-icon"></i>
                        <span id="loketText">-</span>
                    </div>
                    
                    <div class="service-badge" id="serviceBadge" style="display: none;">
                        <span id="serviceText">-</span>
                    </div>
                </div>

                <!-- Next Queue -->
                <div class="next-queue fade-in">
                    <div class="next-queue-header">
                        <div class="next-queue-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Antrian Berikutnya</h3>
                    </div>
                    
                    <div id="nextQueue">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <h4>Menunggu Data</h4>
                            <p>Sistem sedang memuat informasi antrian...</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="sidebar">
                <!-- Clock -->
                <div class="clock-card fade-in">
                    <div class="clock-header">
                        <i class="fas fa-clock clock-icon"></i>
                        <h3>Waktu Saat Ini</h3>
                    </div>
                    <div class="clock-time" id="clock">--:--:--</div>
                    <div class="clock-date" id="date">-</div>
                </div>

                <!-- Statistics -->
                <div class="stats-card fade-in">
                    <div class="stats-header">
                        <div class="stats-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3>Statistik Antrian</h3>
                    </div>
                    
                    <div class="stat-item stat-total">
                        <div class="stat-item-left">
                            <div class="stat-item-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="stat-label">Total Antrian</span>
                        </div>
                        <span class="stat-value" id="totalAntrian">0</span>
                    </div>
                    
                    <div class="stat-item stat-completed">
                        <div class="stat-item-left">
                            <div class="stat-item-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <span class="stat-label">Selesai</span>
                        </div>
                        <span class="stat-value" id="completedAntrian">0</span>
                    </div>
                    
                    <div class="stat-item stat-waiting">
                        <div class="stat-item-left">
                            <div class="stat-item-icon">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <span class="stat-label">Menunggu</span>
                        </div>
                        <span class="stat-value" id="waitingAntrian">0</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Desktop Running Text -->
    <div class="running-text">
        <div class="running-text-content" id="runningTextContent">
            <div class="running-text-item">
                <i class="fas fa-star running-text-icon"></i>
                <span>Selamat datang di QueueBank ProMax</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-ticket-alt running-text-icon"></i>
                <span>Silakan ambil nomor antrian sesuai kebutuhan Anda</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-heart running-text-icon"></i>
                <span>Terima kasih atas kepercayaan Anda</span>
            </div>
            <div class="running-text-item">
                <i class="fas fa-shield-alt running-text-icon"></i>
                <span>Sistem Antrian Digital Terdepan</span>
            </div>
        </div>
    </div>

    <script>
        // Sample data for demonstration
        let queueData = [
            {
                id: '1',
                nomor_antrian: 'A001',
                status: 'dipanggil',
                loket_id: 1,
                nama_loket: 'Teller 1',
                nama_kategori: 'Tabungan',
                timestamp: new Date()
            },
            {
                id: '2',
                nomor_antrian: 'A002',
                status: 'menunggu',
                loket_id: 2,
                nama_loket: 'Teller 2',
                nama_kategori: 'Transfer',
                timestamp: new Date()
            },
            {
                id: '3',
                nomor_antrian: 'A003',
                status: 'menunggu',
                loket_id: 1,
                nama_loket: 'Teller 1',
                nama_kategori: 'Deposito',
                timestamp: new Date()
            },
            {
                id: '4',
                nomor_antrian: 'A004',
                status: 'menunggu',
                loket_id: 3,
                nama_loket: 'Customer Service',
                nama_kategori: 'Pembukaan Rekening',
                timestamp: new Date()
            },
            {
                id: '5',
                nomor_antrian: 'A005',
                status: 'menunggu',
                loket_id: 2,
                nama_loket: 'Teller 2',
                nama_kategori: 'Penarikan Tunai',
                timestamp: new Date()
            }
        ];

        // Update display function
        function updateDisplay() {
            // Find current queue (being called)
            const current = queueData.find(item => item.status === 'dipanggil');
            const currentNumberEl = document.getElementById('currentNumber');
            const currentLoketEl = document.getElementById('currentLoket');
            const loketTextEl = document.getElementById('loketText');
            const serviceBadgeEl = document.getElementById('serviceBadge');
            const serviceTextEl = document.getElementById('serviceText');

            if (current) {
                // Animate number change
                if (currentNumberEl.textContent !== current.nomor_antrian) {
                    currentNumberEl.classList.add('animate');
                    setTimeout(() => {
                        currentNumberEl.classList.remove('animate');
                    }, 600);
                }

                currentNumberEl.textContent = current.nomor_antrian;
                loketTextEl.textContent = current.nama_loket || `Loket ${current.loket_id}`;
                serviceTextEl.textContent = current.nama_kategori;
                currentLoketEl.style.display = 'flex';
                serviceBadgeEl.style.display = 'inline-flex';
            } else {
                currentNumberEl.textContent = '-';
                currentLoketEl.style.display = 'none';
                serviceBadgeEl.style.display = 'none';
            }

            // Update next queue
            const nextQueues = queueData.filter(item => item.status === 'menunggu').slice(0, 3);
            const nextQueueEl = document.getElementById('nextQueue');

            if (nextQueues.length > 0) {
                let nextHtml = '';
                nextQueues.forEach((queue, index) => {
                    const positionClass = index === 0 ? 'position-1' : index === 1 ? 'position-2' : 'position-3';
                    const statusClass = index === 0 ? 'status-next' : 'status-waiting';
                    const statusText = index === 0 ? 'Selanjutnya' : `+${index + 1}`;

                    nextHtml += `
                        <div class="queue-item">
                            <div class="queue-item-left">
                                <div class="queue-position ${positionClass}">${index + 1}</div>
                                <div class="queue-details">
                                    <h4>${queue.nomor_antrian}</h4>
                                    <p>${queue.nama_kategori}</p>
                                </div>
                            </div>
                            <div class="queue-status ${statusClass}">${statusText}</div>
                        </div>
                    `;
                });
                nextQueueEl.innerHTML = nextHtml;
            } else {
                nextQueueEl.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h4>Tidak ada antrian menunggu</h4>
                        <p>Semua antrian telah selesai diproses</p>
                    </div>
                `;
            }

            // Update statistics
            const total = queueData.length;
            const completed = queueData.filter(item => item.status === 'selesai').length;
            const waiting = queueData.filter(item => item.status === 'menunggu').length;

            document.getElementById('totalAntrian').textContent = total;
            document.getElementById('completedAntrian').textContent = completed;
            document.getElementById('waitingAntrian').textContent = waiting;

            // Update mobile info cards
            document.getElementById('mobileTotalAntrian').textContent = total;
            document.getElementById('mobileSedangDipanggil').textContent = queueData.filter(item => item.status === 'dipanggil').length;
            document.getElementById('mobileSedangMenunggu').textContent = waiting > 0 ? waiting : '-';
            
            // Update mobile last update time
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('mobileUpdateTerakhir').textContent = timeString;
        }

        // Update clock function
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const dateString = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            document.getElementById('clock').textContent = timeString;
            document.getElementById('date').textContent = dateString;
        }

        // Simulate queue progression
        function simulateQueueProgression() {
            // Randomly progress queue status
            const randomIndex = Math.floor(Math.random() * queueData.length);
            const item = queueData[randomIndex];

            if (item.status === 'menunggu') {
                // Sometimes call a waiting queue
                if (Math.random() > 0.7) {
                    // First, mark current as completed
                    const current = queueData.find(q => q.status === 'dipanggil');
                    if (current) {
                        current.status = 'selesai';
                    }
                    // Then call the next one
                    item.status = 'dipanggil';
                }
            } else if (item.status === 'dipanggil') {
                // Sometimes complete current queue
                if (Math.random() > 0.8) {
                    item.status = 'selesai';
                }
            }

            // Occasionally add new queue items
            if (Math.random() > 0.9 && queueData.length < 10) {
                const newId = (queueData.length + 1).toString();
                const queueNumber = `A${String(queueData.length + 1).padStart(3, '0')}`;
                const services = ['Tabungan', 'Transfer', 'Deposito', 'Pembukaan Rekening', 'Penarikan Tunai', 'Kredit'];
                const lokets = ['Teller 1', 'Teller 2', 'Customer Service'];
                
                queueData.push({
                    id: newId,
                    nomor_antrian: queueNumber,
                    status: 'menunggu',
                    loket_id: Math.floor(Math.random() * 3) + 1,
                    nama_loket: lokets[Math.floor(Math.random() * lokets.length)],
                    nama_kategori: services[Math.floor(Math.random() * services.length)],
                    timestamp: new Date()
                });
            }
        }

        // API simulation functions (replace with actual API calls)
        function fetchQueueData() {
            // In real implementation, replace with:
            // fetch('/display/antrian')
            //     .then(response => response.json())
            //     .then(data => {
            //         queueData = data;
            //         updateDisplay();
            //     });
            
            simulateQueueProgression();
            updateDisplay();
        }

        function fetchSettings() {
            // In real implementation, replace with:
            // fetch('/display/pengaturan')
            //     .then(response => response.json())
            //     .then(data => {
            //         if (data.teks_berjalan) {
            //             updateRunningText(data.teks_berjalan);
            //         }
            //     });
        }

        // Initialize
        function init() {
            updateDisplay();
            updateClock();
            
            // Set intervals
            setInterval(fetchQueueData, 3000); // Update queue every 3 seconds
            setInterval(updateClock, 1000); // Update clock every second
            setInterval(fetchSettings, 10000); // Update settings every 10 seconds
        }

        // Start the application
        document.addEventListener('DOMContentLoaded', init);

        // Add some visual feedback for interactions
        document.addEventListener('click', function(e) {
            // Add ripple effect to clickable elements
            if (e.target.closest('.queue-item, .stat-item')) {
                const element = e.target.closest('.queue-item, .stat-item');
                element.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    element.style.transform = '';
                }, 150);
            }
        });

        // Add keyboard shortcuts for testing
        document.addEventListener('keydown', function(e) {
            if (e.key === 'n' || e.key === 'N') {
                // Simulate next queue call
                const waiting = queueData.find(item => item.status === 'menunggu');
                if (waiting) {
                    const current = queueData.find(item => item.status === 'dipanggil');
                    if (current) current.status = 'selesai';
                    waiting.status = 'dipanggil';
                    updateDisplay();
                }
            } else if (e.key === 'c' || e.key === 'C') {
                // Complete current queue
                const current = queueData.find(item => item.status === 'dipanggil');
                if (current) {
                    current.status = 'selesai';
                    updateDisplay();
                }
            }
        });
    </script>
</body>
</html>
