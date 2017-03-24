from subprocess import check_output
import json

config = check_output(['php', '-r', 'echo json_encode(include "../config/countersfields.php");'])
config = json.loads(config.decode('utf-8'))

for item in config['eri']['3g']:
	print(item)