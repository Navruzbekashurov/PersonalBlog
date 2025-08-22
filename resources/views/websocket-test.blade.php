<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebSocket Test</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <div style="padding: 20px; font-family: Arial, sans-serif;">
        <h1>WebSocket Connection Test</h1>
        <div id="status" style="padding: 10px; margin: 10px 0; background: #f0f0f0; border-radius: 5px;">
            Status: Initializing...
        </div>
        <div id="logs" style="height: 400px; overflow-y: scroll; border: 1px solid #ccc; padding: 10px; background: #f9f9f9;">
            <div style="color: #666;">Logs will appear here...</div>
        </div>
        <button onclick="testConnection()" style="padding: 10px 20px; margin: 10px 0; background: #007cba; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Test Connection
        </button>
    </div>

    <script>
        const statusDiv = document.getElementById('status');
        const logsDiv = document.getElementById('logs');
        
        function addLog(message, type = 'info') {
            const time = new Date().toLocaleTimeString();
            const colors = {
                info: '#333',
                success: '#28a745',
                error: '#dc3545',
                warning: '#ffc107'
            };
            
            const logEntry = document.createElement('div');
            logEntry.style.color = colors[type] || colors.info;
            logEntry.style.marginBottom = '5px';
            logEntry.innerHTML = `[${time}] ${message}`;
            
            logsDiv.appendChild(logEntry);
            logsDiv.scrollTop = logsDiv.scrollHeight;
        }
        
        function updateStatus(message, type = 'info') {
            const colors = {
                info: '#17a2b8',
                success: '#28a745',
                error: '#dc3545',
                warning: '#ffc107'
            };
            
            statusDiv.style.backgroundColor = colors[type] + '20';
            statusDiv.style.color = colors[type];
            statusDiv.innerHTML = `Status: ${message}`;
        }
        
        function testConnection() {
            addLog('🧪 Testing WebSocket connection...', 'info');
            
            if (window.Echo) {
                addLog('✅ Echo instance found', 'success');
                
                // Test channel subscription
                const channel = window.Echo.channel('test-channel');
                addLog('📡 Subscribed to test-channel', 'info');
                
                updateStatus('Connected and testing...', 'success');
            } else {
                addLog('❌ Echo instance not found', 'error');
                updateStatus('Echo not initialized', 'error');
            }
        }
        
        // Wait for Echo to be initialized
        document.addEventListener('DOMContentLoaded', function() {
            addLog('🚀 Page loaded, waiting for Echo...', 'info');
            
            setTimeout(() => {
                if (window.Echo) {
                    addLog('✅ Echo initialized successfully', 'success');
                    updateStatus('Echo ready', 'success');
                    
                    // Test automatic connection
                    testConnection();
                } else {
                    addLog('❌ Echo failed to initialize', 'error');
                    updateStatus('Echo initialization failed', 'error');
                }
            }, 2000);
        });
        
        // Override console.log to capture Echo logs
        const originalLog = console.log;
        console.log = function(...args) {
            originalLog.apply(console, args);
            if (args[0] && typeof args[0] === 'string') {
                addLog(args.join(' '), 'info');
            }
        };
        
        const originalError = console.error;
        console.error = function(...args) {
            originalError.apply(console, args);
            if (args[0] && typeof args[0] === 'string') {
                addLog(args.join(' '), 'error');
            }
        };
    </script>
</body>
</html>
