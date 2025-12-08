@extends('layouts.admin')

@section('title', 'Participants')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/create-duties.css') }}">
    <style>
                /* --- MOBILE/TABLET ONLY: Responsive table for participants view --- */
                @media (max-width: 768px) {
                    .table-section {
                        overflow-x: auto !important;
                        -webkit-overflow-scrolling: touch;
                        background: #fff;
                    }
                    .table-responsive {
                        overflow-x: auto !important;
                        -webkit-overflow-scrolling: touch;
                        white-space: nowrap !important;
                    }
                    .table {
                        min-width: 600px !important;
                        width: auto !important;
                        font-size: 0.85rem;
                    }
                    .table thead th, .table tbody td {
                        white-space: nowrap !important;
                        padding: 10px 8px !important;
                        vertical-align: middle !important;
                    }
                    .table thead th {
                        font-size: 0.75rem;
                    }
                    .table tbody td {
                        font-size: 0.85rem;
                    }
                    .table tbody td:last-child {
                        text-align: right !important;
                    }
                }
                @media (max-width: 480px) {
                    .table {
                        min-width: 500px !important;
                    }
                    .table thead th, .table tbody td {
                        padding: 8px 4px !important;
                    }
                }
        /* Professional card layout for participants page */
        .participants-wrap { 
            margin-left: 240px !important;
            margin-top: 20px !important;
            padding: 24px;
            max-width: calc(100% - 240px);
        }
        
        .card-participants {
            background: #fff;
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .participants-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }
        
        .participants-header h3 {
            color: #1a1a4d;
            font-size: 1.75rem;
            margin: 0 0 8px 0;
            font-weight: 600;
        }
        
        .participants-header p {
            margin: 0;
            color: #6b7280;
            font-size: 0.95rem;
        }
        
        .table {
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }
        
        .table thead th {
            background: #1a1a4d;
            color: #FFD700;
            font-weight: 600;
            padding: 14px 16px;
            border: none;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table thead th:first-child {
            border-radius: 8px 0 0 0;
        }
        
        .table thead th:last-child {
            border-radius: 0 8px 0 0;
        }
        
        .table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
            color: #374151;
            text-align: center;
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .table tbody tr:hover {
            background-color: #f9fafb;
        }
        
        .btn-purple {
            background: #1a1a4d;
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            transition: all 0.2s;
            font-weight: 500;
        }
        
        .btn-purple:hover {
            background: #2a2a5d;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(26, 26, 77, 0.2);
        }
        
        .btn-purple-outline {
            background: transparent;
            color: #1a1a4d;
            border: 2px solid #1a1a4d;
            padding: 8px 24px;
            border-radius: 6px;
            transition: all 0.2s;
            font-weight: 500;
        }
        
        .btn-purple-outline:hover {
            background: #1a1a4d;
            color: #fff;
        }
        
        .btn-add {
            background: #1a1a4d;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            transition: all 0.2s;
            font-weight: 500;
        }
        
        .btn-add:hover:not(:disabled) {
            background: #2a2a5d;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(26, 26, 77, 0.2);
        }
        
        .btn-add:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            opacity: 0.6;
        }
        
        .participant-stats {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border-left: 4px solid #FFD700;
            border-radius: 10px;
            padding: 20px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            flex: 1;
            min-width: 300px;
        }

        .participant-stats .tl-label {
            color: #92400e;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .participant-stats .tl-name {
            font-weight: 700;
            color: #1a1a4d;
            font-size: 1.25rem;
            margin-bottom: 4px;
        }

        .participant-stats .tl-email {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .search-participants {
            min-width: 280px;
            border-radius: 6px;
            border: 2px solid #e5e7eb;
            padding: 10px 16px;
            transition: all 0.2s;
        }
        
        .search-participants:focus {
            border-color: #1a1a4d;
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 26, 77, 0.1);
        }

        /* Layout adjustments */
        .participant-top { 
            display: flex; 
            justify-content: space-between; 
            gap: 24px; 
            align-items: stretch; 
            flex-wrap: wrap;
            margin-bottom: 24px;
        }
        
        @media (max-width: 900px) { 
            .participant-top { 
                flex-direction: column; 
            }
            .participants-wrap {
                padding: 16px;
            }
            .card-participants {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .participants-wrap {
                margin-left: 0 !important;
                margin-top: 90px !important;
                padding: 12px;
                max-width: 100%;
            }

            .card-participants {
                padding: 16px;
                border-radius: 8px;
            }

            .participants-header {
                flex-direction: column;
                gap: 12px;
                margin-bottom: 16px;
            }

            .participants-header h3 {
                font-size: 1.25rem;
                margin-bottom: 4px;
            }

            .participants-header p {
                font-size: 0.85rem;
            }

            .d-flex.gap-2 {
                flex-direction: column;
                width: 100%;
            }

            .btn-add {
                width: 100%;
                padding: 12px 16px;
            }

            .participant-stats {
                min-width: 100%;
                padding: 16px;
            }

            .search-row {
                flex-direction: column;
                gap: 8px;
                margin-bottom: 16px;
            }

            .search-participants {
                width: 100%;
                min-width: auto;
                padding: 10px 12px;
                font-size: 14px;
            }

            .btn-purple-outline {
                width: 100%;
                padding: 10px 16px;
            }

            .table {
                font-size: 0.85rem;
            }

            .table thead th {
                padding: 10px 8px;
                font-size: 0.75rem;
                letter-spacing: 0.3px;
            }

            .table tbody td {
                padding: 10px 8px;
                font-size: 0.85rem;
                word-break: break-word;
            }

            .card-footer {
                flex-direction: column;
                gap: 12px;
                align-items: stretch;
                margin-top: 16px;
                padding-top: 16px;
            }

            .btn-back, .btn-warning {
                width: 100%;
                text-align: center;
                padding: 12px 16px;
            }

            .text-end {
                text-align: left;
            }

            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                border-radius: 8px;
                max-width: 100%;
                scroll-behavior: smooth;
            }

            .table-responsive::-webkit-scrollbar {
                height: 6px;
            }

            .table-responsive::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background: #1a1a4d;
                border-radius: 3px;
            }

            .table-section {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table {
                min-width: 600px;
            }

            #addStudentModal .modal-dialog {
                max-width: 95vw !important;
                min-width: 0;
                margin: 1.5rem auto;
            }

            #addStudentModal .modal-content {
                width: 95vw;
                border-radius: 12px;
                max-height: 90vh;
                display: flex;
                flex-direction: column;
            }

            #addStudentModal .modal-header {
                padding: 12px 16px 6px 16px;
                flex-shrink: 0;
            }

            #addStudentModal .modal-title {
                font-size: 1.5rem;
            }

            #addStudentModal .modal-body {
                padding: 12px 16px;
                flex: 1;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            #addStudentModal .modal-footer {
                padding: 8px 16px;
                flex-wrap: wrap;
                gap: 8px;
                flex-shrink: 0;
            }

            #addStudentModal .d-flex[role="search"] {
                flex-direction: column;
                gap: 8px;
                margin-bottom: 16px;
            }

            #addStudentModal #addStudentSearch {
                width: 100%;
                padding: 12px 16px;
                font-size: 1rem;
            }

            #addStudentModal #btnAddStudentSearch {
                width: 100%;
                padding: 12px 16px;
            }

            #addStudentResultsBox {
                max-height: 40vh;
                min-height: 50px;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            #addStudentResults th {
                padding: 10px 6px;
                font-size: 0.8rem;
                letter-spacing: 0.4px;
            }

            #addStudentResults td {
                padding: 6px 4px;
                font-size: 0.85rem;
            }

            .modal-footer .btn {
                flex: 1;
                min-width: 80px;
                padding: 10px 12px;
            }

            #setTlModal .modal-dialog {
                max-width: 95vw;
                margin: 1.5rem auto;
            }

            #setTlModal .modal-content {
                border-radius: 12px;
            }

            #setTlModal .modal-header {
                padding: 12px 16px;
            }

            #setTlModal .modal-body {
                padding: 16px;
            }

            #setTlModal .modal-footer {
                padding: 8px 16px;
            }

            .form-select {
                padding: 10px 12px !important;
                font-size: 0.95rem !important;
            }

            .btn-icon {
                gap: 6px;
            }

            .btn-sm {
                padding: 6px 12px !important;
                font-size: 0.8rem !important;
            }
        }

        @media (max-width: 480px) {
            .participants-wrap {
                padding: 8px;
            }

            .card-participants {
                padding: 12px;
            }

            .participants-header h3 {
                font-size: 1.1rem;
            }

            .participants-header p {
                font-size: 0.8rem;
            }

            .table {
                font-size: 0.75rem;
            }

            .table thead th {
                padding: 8px 4px;
                font-size: 0.65rem;
            }

            .table tbody td {
                padding: 8px 4px;
                font-size: 0.75rem;
            }

            .btn-add, .btn-purple-outline, .btn-back, .btn-warning {
                padding: 10px 12px;
                font-size: 0.85rem;
            }

            .search-participants {
                padding: 8px 10px;
                font-size: 13px;
            }

            .participant-stats {
                padding: 12px;
            }

            .participant-stats .tl-name {
                font-size: 1.1rem;
            }

            .participant-stats .tl-label {
                font-size: 0.7rem;
            }

            .participant-stats .tl-email {
                font-size: 0.8rem;
            }

            #addStudentModal .modal-title {
                font-size: 1.25rem;
            }

            #addStudentModal .modal-header {
                padding: 10px 12px 6px 12px;
                background: linear-gradient(135deg, #1a1a4d 0%, #2a2a5d 100%);
                color: white;
            }

            #addStudentModal .modal-header p {
                font-size: 0.8rem;
            }

            #addStudentModal .modal-body {
                padding: 10px 12px;
            }

            #addStudentModal .modal-footer {
                padding: 6px 12px;
            }

            #addStudentModal .d-flex[role="search"] {
                flex-direction: column;
                gap: 6px;
                margin-bottom: 12px;
            }

            #addStudentModal #addStudentSearch {
                font-size: 0.95rem;
                padding: 10px 12px;
                width: 100%;
            }

            #addStudentModal #btnAddStudentSearch {
                width: 100%;
                padding: 10px 12px;
                font-size: 0.9rem;
            }

            #addStudentResultsBox {
                max-height: 35vh;
                border-radius: 8px;
                margin-bottom: 6px;
            }

            #addStudentResults th {
                padding: 8px 4px;
                font-size: 0.7rem;
                letter-spacing: 0.3px;
            }

            #addStudentResults td {
                padding: 6px 3px;
                font-size: 0.75rem;
            }

            .btn-add-row {
                padding: 6px 10px !important;
                font-size: 0.75rem !important;
            }

            .modal-footer .btn {
                font-size: 0.8rem;
                padding: 8px 10px !important;
            }

            .alert {
                padding: 10px 12px;
                font-size: 0.85rem;
                margin-bottom: 12px;
            }

            .badge-muted {
                padding: 4px 8px;
                font-size: 0.75rem;
            }
        }

        .search-row { 
            display: flex; 
            gap: 12px; 
            align-items: center;
            flex-wrap: wrap;
        }
        
        .card-footer { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-top: 24px;
            padding-top: 24px;
            border-top: 2px solid #e5e7eb;
        }
        
        .btn-back { 
            background: transparent; 
            border: 2px solid #1a1a4d; 
            color: #1a1a4d; 
            padding: 8px 16px; 
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
            min-width: 120px;
            justify-content: center;
        }
        
        .btn-back:hover {
            background: #1a1a4d;
            color: #fff;
        }
        
        .btn-back svg { 
            margin-right: 4px;
        }
        
        .card-footer .btn-warning {
            padding: 8px 16px;
            font-size: 0.9rem;
            min-width: 120px;
            font-weight: 500;
        }
        
        .btn-icon { 
            display: inline-flex; 
            align-items: center; 
            gap: 8px;
        }

        .badge-muted { 
            background: #f3f4f6; 
            color: #374151; 
            padding: 6px 12px; 
            border-radius: 20px; 
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .table-section {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 8px;
            max-width: 100%;
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #1a1a4d;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #2a2a5d;
        }

        .table {
            min-width: 100%;
        }
        
        /* Modal Improvements */
        .modal-dialog-centered {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: calc(100vh - 3.5rem) !important;
            margin: 1.75rem auto !important;
        }
        
        .modal.show .modal-dialog {
            transform: none !important;
        }
        
        .modal-content {
            border-radius: 16px;
            border: none;
            overflow: hidden;
        }
        
        .modal-header {
            border: none;
            padding: 24px 32px;
        }
        
        .modal-body {
            padding: 24px 32px;
        }
        
        .modal-footer {
            border: none;
            padding: 20px 32px;
        }
        
        .form-select:focus {
            border-color: #1a1a4d;
            box-shadow: 0 0 0 3px rgba(26, 26, 77, 0.1);
        }
        

        #addStudentModal .modal-dialog {
            max-width: 98vw;
            min-width: 0;
            width: 100%;
            margin: 2.5rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #addStudentModal .modal-content {
            border-radius: 20px;
            box-shadow: 0 12px 48px rgba(0,0,0,0.18);
            padding: 0;
            max-width: 800px;
            width: 98vw;
            margin: 0 auto;
        }
        #addStudentModal .modal-header {
            background: linear-gradient(135deg, #1a1a4d 0%, #2a2a5d 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 16px 36px 8px 36px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        #addStudentModal .modal-title {
            font-weight: 800;
            font-size: 2rem;
            letter-spacing: 0.5px;
        }
        #addStudentModal .modal-header p {
            margin: 8px 0 0 0;
            font-size: 1.05rem;
            opacity: 0.95;
        }
        #addStudentModal .btn-close {
            filter: brightness(0) invert(1);
            position: absolute;
            top: 24px;
            right: 32px;
            z-index: 10;
        }
        #addStudentModal .modal-body {
            display: flex;
            flex-direction: column;
            padding: 12px 36px 12px 36px;
            background: #fafbfc;
        }
        #addStudentModal .modal-footer {
            background: #fafbfc;
            border-top: 2px solid #e5e7eb;
            padding: 10px 36px;
            border-radius: 0 0 20px 20px;
        }
        #addStudentModal .d-flex[role="search"] {
            width: 100%;
            max-width: 100%;
            margin-bottom: 28px;
            gap: 16px;
        }
        #addStudentModal #addStudentSearch {
            flex: 1;
            border-radius: 10px;
            padding: 16px 22px;
            border: 2px solid #e5e7eb;
            font-size: 1.05rem;
            background: #fff;
            box-shadow: 0 1px 2px rgba(26,26,77,0.03);
        }
        #addStudentModal #addStudentSearch:focus {
            border-color: #1a1a4d;
            outline: none;
            box-shadow: 0 0 0 3px rgba(26, 26, 77, 0.12);
        }
        #addStudentModal #btnAddStudentSearch {
            padding: 16px 36px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.05rem;
            background: #1a1a4d;
            border: none;
            box-shadow: 0 2px 8px rgba(26,26,77,0.08);
        }
        #addStudentModal #btnAddStudentSearch:hover {
            background: #2a2a5d;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(26, 26, 77, 0.18);
        }
        

        /* Add Student Modal: Scrollable Results */
        #addStudentResultsBox {
            max-height: 40vh;
            min-height: 60px;
            overflow-y: auto;
            overflow-x: auto;
            border-radius: 14px;
            border: 1.5px solid #e5e7eb;
            background: #fff;
            margin-bottom: 8px;
            width: 100%;
            box-shadow: 0 2px 8px rgba(26,26,77,0.04);
            -webkit-overflow-scrolling: touch;
        }

        #addStudentResultsBox::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        #addStudentResultsBox::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #addStudentResultsBox::-webkit-scrollbar-thumb {
            background: #1a1a4d;
            border-radius: 10px;
        }

        #addStudentResultsBox::-webkit-scrollbar-thumb:hover {
            background: #2a2a5d;
        }

        #addStudentResults {
            width: 100%;
            margin: 0;
            background: white;
            border-radius: 0;
            border: none;
            min-width: 100%;
        }
        #addStudentResults th {
            background: #1a1a4d;
            color: #FFD700;
            padding: 14px 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            font-size: 1.01rem;
            position: sticky;
            top: 0;
            z-index: 2;
        }
        #addStudentResults td {
            padding: 7px 8px;
            border-bottom: 1px solid #f3f4f6;
            background: #fff;
            font-size: 0.97rem;
        }
        #addStudentResults tbody tr:last-child td {
            border-bottom: none;
        }
        #addStudentResults tbody tr:hover {
            background: #f9fafb;
        }
        
        #addStudentMessage {
            padding: 12px 16px;
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            border-radius: 6px;
            margin-bottom: 16px;
        }
        
        .alert {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-color: #10b981;
        }
        
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border-color: #ef4444;
        }
        
        .text-end {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-muted {
            color: #6b7280 !important;
        }
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 200;
            background: linear-gradient(to right, #000066, #191970)
            height: 90px;
        }
        
        /* SIDEBAR - FIXED UNDER HEADER */
        .sidebar {
            background: linear-gradient(to bottom, #000066, #0A0A40);
            width: 240px;
            padding: 20px 0 0 0; 
            display: flex;
            flex-direction: column;
            align-items: center;
            position: fixed;
            top: 90px;
            left: 0;
            height: calc(100vh - 90px);
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-title {
            color: #FFD700;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 18px;
            flex-shrink: 0;
            padding: 0 20px;
        }

        .menu {
            list-style: none;
            width: 100%;
            flex: 1;
            overflow-y: auto; 
            padding: 0;
            margin: 0;
        }

        .menu li {
            color: white;
            padding: 12px 25px;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .menu li a.menu-link {
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .menu li a.menu-link img.icon {
            width: 22px;
            height: 22px;
            margin-right: 12px;
            filter: brightness(0) invert(1);
        }

        .menu li:hover,
        .menu li.active {
            background-color: #FFD700;
            color: black;
            font-weight: bold;
        }

        .menu li.active img.icon,
        .menu li:hover img.icon {
            filter: brightness(0);
        }

        .logout-btn {
            background-color: #FFD700;
            color: black;
            font-weight: bold;
            border: none;
            padding: 10px 25px;
            border-radius: 30px;
            margin: 20px; 
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0; 
            width: calc(100% - 40px); 
        }

        .logout-btn:hover {
            background-color: #ffea00;
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.8);
        }

    </style>
@endsection

@section('content')
    @php
        // Compute duty id and safe action URL for setting team leader.
        $dutyId = $duty->event_id ?? $duty->id ?? ($duty->{$duty->getKeyName()} ?? null);
        $setTlAction = $dutyId ? route('admin.duties.set_tl', $dutyId) : '#';
    @endphp

    <div class="participants-wrap">
        <div class="card-participants">
            <!-- Flash messages -->
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="participants-header">
                <div>
                    <h3>Participants for: {{ $duty->title ?? 'Duty' }}</h3>
                    <p>{{ optional($duty->duty_date)->format('M d, Y') ?? '' }} • {{ $duty->start_time ?? '' }} - {{ $duty->end_time ?? '' }}</p>
                </div>

                <div class="d-flex gap-2 align-items-center">
                    @php
                        $currentCount = is_array($duty->participants ?? null) ? count($duty->participants) : (isset($duty->participants) && is_object($duty->participants) ? $duty->participants->count() : 0);
                        $capacity = $duty->number_of_participants ?? null;
                        $isFull = $capacity ? ($currentCount >= $capacity) : false;
                    @endphp
                    <button class="btn btn-add btn-icon" id="addStudentBtn" data-bs-toggle="modal" data-bs-target="#addStudentModal" {{ $isFull ? 'disabled' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 4a.5.5 0 0 1 .5.5V7.5H11.5a.5.5 0 0 1 0 1H8.5V11.5a.5.5 0 0 1-1 0V8.5H4.5a.5.5 0 0 1 0-1H7.5V4.5A.5.5 0 0 1 8 4z"/>
                        </svg>
                        Add Student
                    </button>
                </div>
            </div>

            <div>
                @php
                    // Show blank when no team leader is set (null or empty). This keeps the UI clean.
                    $tlName = '';
                    $tlEmail = null;
                    if (!empty($duty->team_leader_name)) {
                        $tlName = $duty->team_leader_name;
                    } elseif (isset($duty->team_leader) && is_object($duty->team_leader)) {
                        $tlName = $duty->team_leader->name ?? '';
                        $tlEmail = $duty->team_leader->email ?? null;
                    }
                @endphp

                <div class="participant-top">
                    <div class="participant-stats">
                        <div class="tl-label">Team Leader</div>
                        <div class="tl-name">{{ $tlName ?: 'Not assigned' }}</div>
                        @if($tlEmail)
                            <div class="tl-email">{{ $tlEmail }}</div>
                        @endif
                    </div>
                </div>

                <!-- search row below duty details -->
                <div class="search-row">
                    <input id="searchParticipant" type="search" class="form-control search-participants" placeholder="Search by PLV ID or name...">
                    <button id="btnSearchParticipant" class="btn btn-purple-outline">Search</button>
                </div>

                <div class="table-section mt-4">
                    <div class="table-responsive">
                        <table id="participantsTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>PLV ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($duty->participants ?? [] as $participant)
                                    @php
                                        $pid = $participant->participant_id ?? $participant->plv_student_id ?? null;
                                        $dutyId = $duty->event_id ?? $duty->id ?? $duty->{$duty->getKeyName()} ?? null;
                                        $plv = $participant->plv_student_id ?? ($participant->plv_id ?? '');
                                        $fullname = trim(($participant->first_name ?? '') . ' ' . ($participant->last_name ?? '')) ?: ($participant->name ?? 'N/A');
                                    @endphp
                                    <tr data-name="{{ strtolower($fullname) }}" data-plv="{{ strtolower($plv) }}">
                                        <td>{{ $plv ?: 'N/A' }}</td>
                                        <td>{{ $fullname }}</td>
                                        <td>{{ $participant->email ?? 'N/A' }}</td>
                                        <td class="text-end">
                                            @if($pid && $dutyId)
                                                <form method="POST" action="{{ route('admin.duties.participants.remove', [$dutyId, $pid]) }}" onsubmit="return confirm('Are you sure you want to remove this participant?')" style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm px-3">Remove</button>
                                                </form>
                                            @else
                                                <button class="btn btn-danger btn-sm px-3" disabled title="Missing participant id">Remove</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No participants found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- card footer: back (left) and set TL (right) -->
                <div class="card-footer">
                    <div>
                            <button type="button" class="btn-back" aria-label="Back to Duties" onclick="window.location='{{ route('admin.in-progress') }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H3.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L3.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                                </svg>
                                Back to Duties
                            </button>
                        </div>
                    <div>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#setTlModal">Set Team Leader</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Add Student modal (centered, larger) -->
        <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title" id="addStudentModalLabel">Add Student to Duty</h5>
                            <p style="margin: 6px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Search and add participants to this duty</p>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        <!-- Floating close button -->
                        <button type="button" class="btn btn-danger" id="addStudentFloatingClose" style="position: absolute; top: 8px; right: 54px; z-index: 20; border-radius: 50%; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; box-shadow: 0 2px 8px rgba(0,0,0,0.12);" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex mb-3" role="search">
                            <input id="addStudentSearch" class="form-control" placeholder="Search by PLV ID or name...">
                            <button id="btnAddStudentSearch" class="btn btn-primary ms-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right: 6px;">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                </svg>
                                Search
                            </button>
                        </div>

                        <div id="addStudentMessage" class="mb-2 text-muted small"></div>

                        <div id="addStudentResultsBox">
                            <table class="table table-hover" id="addStudentResults">
                                <thead>
                                    <tr>
                                        <th>PLV ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($registeredMembers) && count($registeredMembers) > 0)
                                        @foreach($registeredMembers as $rm)
                                            @php
                                                $rmId = $rm->id ?? $rm->participant_id ?? $rm->plv_student_id ?? '';
                                                $rmPlv = $rm->plv_id ?? $rm->plv_student_id ?? '';
                                                $rmName = trim(($rm->first_name ?? '') . ' ' . ($rm->last_name ?? '')) ?: ($rm->name ?? 'N/A');
                                            @endphp
                                            <tr data-member-id="{{ $rmId }}" data-plv="{{ $rmPlv }}" data-first="{{ $rm->first_name ?? '' }}" data-last="{{ $rm->last_name ?? '' }}" data-email="{{ $rm->email ?? '' }}">
                                                <td>{{ $rmPlv }}</td>
                                                <td>{{ $rmName }}</td>
                                                <td>{{ $rm->email ?? '' }}</td>
                                                <td class="text-end">
                                                    <button class="btn btn-success btn-add-row" style="padding: 7px 18px; border-radius: 7px; font-weight: 700; font-size: 1rem; min-width: 80px;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right: 4px;">
                                                            <path d="M8 4a.5.5 0 0 1 .5.5V7.5H11.5a.5.5 0 0 1 0 1H8.5V11.5a.5.5 0 0 1-1 0V8.5H4.5a.5.5 0 0 1 0-1H7.5V4.5A.5.5 0 0 1 8 4z"/>
                                                        </svg>
                                                        Add
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="4" class="text-center text-muted" style="padding: 40px;">No members available</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 8px; font-weight: 500;">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Set TL modal -->
        <div class="modal fade" id="setTlModal" tabindex="-1" aria-labelledby="setTlModalLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.15); margin: auto;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #1a1a4d 0%, #2a2a5d 100%); color: white; border-radius: 16px 16px 0 0; padding: 24px; border: none;">
                        <div>
                            <h5 class="modal-title" id="setTlModalLabel" style="font-weight: 700; font-size: 1.35rem; margin: 0;">Set Team Leader</h5>
                            <p style="margin: 6px 0 0 0; font-size: 0.9rem; opacity: 0.9;">Assign a team leader for this duty</p>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ $setTlAction }}">
                        @csrf
                        <div class="modal-body" style="padding: 32px;">
                            <div class="mb-4">
                                <label class="form-label" style="font-weight: 600; color: #1a1a4d; margin-bottom: 10px; font-size: 0.95rem;">Select Participant</label>
                                <select name="selected_participant" class="form-select" style="padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 0.95rem; transition: all 0.2s;">
                                    <option value="">-- Choose a participant --</option>
                                    @foreach($duty->participants ?? [] as $p)
                                        <option value="{{ $p->participant_id ?? $p->plv_student_id ?? '' }}">
                                            {{ trim(($p->first_name ?? '') . ' ' . ($p->last_name ?? '')) ?: ($p->name ?? $p->email ?? 'N/A') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 16px; border-radius: 8px;">
                                <div style="display: flex; gap: 12px; align-items: start;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 16 16" fill="#3b82f6" style="flex-shrink: 0; margin-top: 2px;">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                    </svg>
                                    <div>
                                        <div style="font-weight: 600; color: #1e40af; margin-bottom: 4px; font-size: 0.9rem;">Team Leader Role</div>
                                        <div style="color: #1e3a8a; font-size: 0.85rem; line-height: 1.5;">The selected participant will be designated as the team leader and will be responsible for coordinating this duty.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="padding: 20px 32px; border-top: 2px solid #f3f4f6; background: #fafbfc; border-radius: 0 0 16px 16px;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding: 10px 24px; border-radius: 8px; font-weight: 500;">Cancel</button>
                            <button type="submit" class="btn btn-warning" {{ $dutyId ? '' : 'disabled' }} style="padding: 10px 28px; border-radius: 8px; font-weight: 600; background: #fbbf24; border: none; color: #78350f;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor" style="margin-right: 6px;">
                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                </svg>
                                Set Team Leader
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- expose registered members to JS if available for immediate client filtering --}}
    @if(!empty($registeredMembers) && count($registeredMembers) > 0)
        <script>window.registeredMembers = @json($registeredMembers);</script>
    @endif
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // --- Add Student Modal Logic ---
    document.addEventListener('DOMContentLoaded', function(){
        const searchInput = document.getElementById('addStudentSearch');
        const btnSearch = document.getElementById('btnAddStudentSearch');
        const resultsTbody = document.querySelector('#addStudentResults tbody');
        const msg = document.getElementById('addStudentMessage');
        const dutyAddUrl = "{{ route('admin.duties.participants.add', $dutyId) }}";
        const csrf = '{{ csrf_token() }}';
        // Capacity and current count (from server)
        let capacity = @json($duty->number_of_participants ?? null);
        let currentCount = @json(is_array($duty->participants ?? null) ? count($duty->participants) : (isset($duty->participants) && is_object($duty->participants) ? $duty->participants->count() : 0));
        const addStudentBtn = document.getElementById('addStudentBtn');
        const addStudentModal = document.getElementById('addStudentModal');
        const floatingClose = document.getElementById('addStudentFloatingClose');

        // Track already added PLV IDs
        let alreadyAdded = new Set();
        @if($duty->participants)
            @foreach($duty->participants as $p)
                alreadyAdded.add("{{ $p->plv_student_id ?? $p->plv_id ?? '' }}".toLowerCase());
            @endforeach
        @endif

        function setMessage(text, isError=false){
            msg.textContent = text || '';
            msg.className = isError ? 'mb-2 text-danger small' : 'mb-2 text-muted small';
        }

        function attachAddHandlers(container = resultsTbody){
            Array.from(container.querySelectorAll('.btn-add-row')).forEach(btn=>{
                // avoid attaching twice
                if (btn.dataset.hooked === '1') return;
                btn.dataset.hooked = '1';
                btn.onclick = async function(e){
                    const row = e.currentTarget.closest('tr');
                    const plv = row.dataset.plv || '';
                    const first = row.dataset.first || '';
                    const last = row.dataset.last || '';
                    const email = row.dataset.email || '';
                    const displayName = row.querySelector('td:nth-child(2)').textContent.trim();
                    if(!plv){
                        setMessage('Cannot add this member: missing PLV ID', true);
                        return;
                    }
                    if(capacity && currentCount >= capacity){
                        setMessage('Cannot add: duty is already full.', true);
                        disableAddControls();
                        return;
                    }
                    if(alreadyAdded.has(plv)){
                        setMessage('This student is already added.', true);
                        return;
                    }
                    if(!confirm(`Add ${displayName} to this duty?`)) return;
                    const origText = btn.textContent;
                    btn.disabled = true;
                    btn.textContent = 'Adding...';
                    try {
                        const resp = await fetch(dutyAddUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                plv_student_id: plv,
                                first_name: first,
                                last_name: last,
                                email: email
                            })
                        });
                        if(!resp.ok){
                            let msgText = 'Failed to add participant.';
                            try { const data = await resp.json(); if(data && data.message) msgText = data.message; } catch{}
                            setMessage(msgText, true);
                            btn.disabled = false;
                            btn.textContent = origText;
                            return;
                        }
                        alreadyAdded.add(plv);
                        currentCount += 1;
                        btn.disabled = true;
                        btn.textContent = 'Added';
                        setMessage('Student added successfully!');
                        // Disable further adds if full
                        if(capacity && currentCount >= capacity){
                            setMessage('Duty is now full. No more participants can be added.');
                            disableAddControls();
                        }
                        // Optionally update main table (participantsTable)
                        if(window.refreshParticipantsTable) window.refreshParticipantsTable();
                    } catch(err){
                        setMessage('Error adding participant: ' + (err.message||'Unknown error'), true);
                        btn.disabled = false;
                        btn.textContent = origText;
                    }
                };
            });
        }

        function renderResults(items){
            resultsTbody.innerHTML = '';
            if(!items || items.length === 0){
                resultsTbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No results found</td></tr>';
                return;
            }
            items.forEach(u=>{
                const plv = (u.plv_student_id || u.plv_id || '').toLowerCase();
                const isAdded = alreadyAdded.has(plv);
                const isFull = capacity && currentCount >= capacity;
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${u.plv_id || u.plv_student_id || ''}</td>
                    <td>${(u.name || ((u.first_name||'') + ' ' + (u.last_name||''))).trim()}</td>
                    <td>${u.email || ''}</td>
                    <td class="text-end">
                        <button class="btn btn-success btn-add-row" style="padding: 7px 12px; border-radius: 7px; font-weight: 700; font-size: 0.95rem; min-width: 54px;" ${ (isAdded || isFull) ? 'disabled' : '' }>${ isAdded ? 'Added' : (isFull ? 'Full' : `<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16' fill='currentColor' style='margin-right: 4px;'><path d='M8 4a.5.5 0 0 1 .5.5V7.5H11.5a.5.5 0 0 1 0 1H8.5V11.5a.5.5 0 0 1-1 0V8.5H4.5a.5.5 0 0 1 0-1H7.5V4.5A.5.5 0 0 1 8 4z'/></svg>Add`) }</button>
                    </td>
                `;
                const first = u.first_name || (u.name ? (u.name.split(' ')[0]||'') : '');
                const last = u.last_name || (u.name ? (u.name.split(' ').slice(1).join(' ')||'') : '');
                tr.dataset.memberId = u.id || u.participant_id || plv || '';
                tr.dataset.plv = plv;
                tr.dataset.first = first;
                tr.dataset.last = last;
                tr.dataset.email = u.email || '';
                resultsTbody.appendChild(tr);
            });

            // Attach handlers to newly rendered rows
            attachAddHandlers(resultsTbody);
        }

        function disableAddControls(){
            // Disable all add buttons in modal
            Array.from(document.querySelectorAll('.btn-add-row')).forEach(b=>{ b.disabled = true; b.textContent = b.textContent.trim() === 'Added' ? 'Added' : 'Full'; });
            // Disable main Add Student button
            if(addStudentBtn) addStudentBtn.disabled = true;
        }

        async function performSearch(q){
            q = (q||'').trim();
            setMessage('Searching...');
            if(window.registeredMembers && Array.isArray(window.registeredMembers)){
                const arr = window.registeredMembers.filter(u=>{
                    // Search by name (first, last, or full) or PLV ID
                    const name = ((u.name||'') || ((u.first_name||'') + ' ' + (u.last_name||''))).toLowerCase();
                    const plv = (u.plv_id || u.plv_student_id || '').toLowerCase();
                    const first = (u.first_name||'').toLowerCase();
                    const last = (u.last_name||'').toLowerCase();
                    const ql = q.toLowerCase();
                    return !q || name.includes(ql) || plv.includes(ql) || first.includes(ql) || last.includes(ql);
                });
                setMessage('Showing local results');
                renderResults(arr);
                return;
            }
            try{
                const resp = await fetch(`/admin/members/search?q=${encodeURIComponent(q)}`, { headers: { 'Accept':'application/json' } });
                if(!resp.ok) throw new Error('No API');
                const data = await resp.json();
                renderResults(data || []);
                setMessage('Showing server results');
            } catch(err){
                setMessage('Search service not available.', true);
                renderResults([]);
            }
        }

        if(btnSearch){
            btnSearch.addEventListener('click', function(e){ e.preventDefault(); performSearch(searchInput.value); });
        }
        if(searchInput){
            searchInput.addEventListener('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); performSearch(searchInput.value); } });
        }

        if(addStudentModal){
            addStudentModal.addEventListener('show.bs.modal', function(){
                resultsTbody.innerHTML = '<tr><td colspan="4" class="text-center text-muted">No search performed yet</td></tr>';
                setMessage('');
                if(searchInput) searchInput.value = '';
            });
        }
        if(floatingClose){
            floatingClose.addEventListener('click', function(){
                if(window.bootstrap && window.bootstrap.Modal){
                    const modal = window.bootstrap.Modal.getOrCreateInstance(addStudentModal);
                    modal.hide();
                }
            });
        }
    });

        document.addEventListener('DOMContentLoaded', function(){
            const searchInput = document.getElementById('searchParticipant');
            const btnSearch = document.getElementById('btnSearchParticipant');
            const tbody = document.querySelector('#participantsTable tbody');

            function applySearch() {
                const q = (searchInput.value||'').trim().toLowerCase();
                Array.from(tbody.querySelectorAll('tr')).forEach(tr=>{
                    const name = tr.getAttribute('data-name') || '';
                    const plv = tr.getAttribute('data-plv') || '';
                    const matches = !q || name.includes(q) || plv.includes(q);
                    tr.style.display = matches ? '' : 'none';
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', applySearch);
                searchInput.addEventListener('keydown', function(e){ if (e.key === 'Enter') { e.preventDefault(); applySearch(); } });
            }
            if (btnSearch) btnSearch.addEventListener('click', function(e){ e.preventDefault(); applySearch(); });

            const setTlModal = document.getElementById('setTlModal');
            if (setTlModal) {
                setTlModal.addEventListener('show.bs.modal', function(e){
                    const btn = e.relatedTarget;
                    const selectedId = btn?.getAttribute('data-selected-id');
                    if (selectedId) {
                        const sel = setTlModal.querySelector('select[name="selected_participant"]');
                        if (sel) sel.value = selectedId;
                    }

                    try {
                        const form = setTlModal.querySelector('form');
                        if (form) {
                            const act = (form.getAttribute('action') || '').trim();
                            if (!act || act === '#' || act.endsWith('/participants')) {
                                let url = window.location.pathname;
                                if (url.endsWith('/')) url = url.slice(0, -1);
                                if (url.endsWith('/participants')) {
                                    url = url.replace(/\/participants$/, '/set-team-leader');
                                } else {
                                    url = url + '/set-team-leader';
                                }
                                form.setAttribute('action', url);
                            }
                        }
                    } catch (ex) {
                        // ignore
                    }
                });
            }
        });
    </script>