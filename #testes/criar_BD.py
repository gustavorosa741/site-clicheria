from sqlalchemy import Column, Integer, String, Date, Boolean
from sqlalchemy import create_engine
from sqlalchemy.orm import declarative_base, sessionmaker
from dotenv import load_dotenv
import os



load_dotenv()

usuario = os.getenv("USUARIO")
senha = os.getenv("SENHA")

engine = create_engine(f"mysql+pymysql://{usuario}:{senha}@localhost:3306/clicheria?charset=utf8mb4")

Base = declarative_base()
Session = sessionmaker(bind=engine)
session = Session()

class CadastroClicheria(Base):
    __tablename__ = 'tab_clicheria'
    id_cliche = Column(Integer, primary_key=True)
    cliente = Column(String(200), nullable=False)
    produto = Column(String(200), nullable=False)
    codigo = Column(Integer, nullable=False)
    armario = Column(Integer, nullable=False)
    prateleira = Column(String(100), nullable=False)
    cores = Column(Integer,nullable=False)
    cor01 = Column(String(50))
    cor02 = Column(String(50))
    cor03 = Column(String(50))
    cor04 = Column(String(50))
    cor05 = Column(String(50))
    cor06 = Column(String(50))
    cor07 = Column(String(50))
    cor08 = Column(String(50))
    cor09 = Column(String(50))
    cor10 = Column(String(50))
    gravacao01 = Column(Date)
    gravacao02 = Column(Date)
    gravacao03 = Column(Date)
    gravacao04 = Column(Date)
    gravacao05 = Column(Date)
    gravacao06 = Column(Date)
    gravacao07 = Column(Date)
    gravacao08 = Column(Date)
    gravacao09 = Column(Date)
    gravacao10 = Column(Date)
    reserva01 = Column(Boolean)
    reserva02 = Column(Boolean)
    reserva03 = Column(Boolean)
    reserva04 = Column(Boolean)
    reserva05 = Column(Boolean)
    reserva06 = Column(Boolean)
    reserva07 = Column(Boolean)
    reserva08 = Column(Boolean)
    reserva09 = Column(Boolean)
    reserva10 = Column(Boolean)
    observacao = Column(String(200), nullable=False)
    camisa = Column(String(200), nullable=False)





		











def create_tables():
    Base.metadata.create_all(engine)

def main():
    create_tables()
    print("Tabelas criadas com sucesso!")

if __name__ == "__main__":
    main()