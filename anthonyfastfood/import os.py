import os
from dotenv import load_dotenv

load_dotenv()  # .envファイルを読み込む
print(os.getenv("SUPABASE_URL"))