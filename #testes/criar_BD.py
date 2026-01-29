from sqlalchemy import Column, Integer, String, Date, Text, ForeignKey
from sqlalchemy import create_engine
from sqlalchemy.orm import declarative_base, sessionmaker
from dotenv import load_dotenv
import os

load_dotenv()

usuario = os.getenv("USUARIO")
senha = os.getenv("SENHA")

engine = create_engine(f"mysql+pymysql://{usuario}:{senha}@localhost:3306/chamados")

Base = declarative_base()
Session = sessionmaker(bind=engine)
session = Session()

class Chamado(Base):
    __tablename__ = 'clicheria'








def create_tables():
    Base.metadata.create_all(engine)

def main():
    create_tables()
    print("Tabelas criadas com sucesso!")

if __name__ == "__main__":
    main()