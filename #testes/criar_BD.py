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

'''class CadastroClicheria(Base):
    __tablename__ = 'tab_nova_clicheria'
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
    camisa = Column(String(200), nullable=False)'''



class CadastroColagem(Base):
    __tablename__ = 'tab_nova_colagem'
    id_colagem = Column(Integer, primary_key=True)
    produto = Column(String(200), nullable=False)
    codigo = Column(Integer, nullable=False)
    camisa= Column(Integer, nullable=False)
    valor_eng = Column(Integer, nullable=False)
    maquina = Column(String(200), nullable=False)
    valor_pon = Column(Integer, nullable=False)
    familia = Column(String(200), nullable=False)
    cameron = Column(Boolean, nullable=False)
    distanciaCameron = Column(Integer, nullable=False)
    engcameron = Column(Integer, nullable=False)
    maquinaCameron = Column(String(200))
    ponCameron = Column(Integer)
    distanciaCameron2 = Column(Integer, nullable=False)
    observacoes = Column(String(200))
    colador = Column(String(200), nullable=False)
    datacolagem = Column (Date)

    cores =Column(Integer, nullable=False)
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
    densidade01 = Column(String(50))
    densidade02 = Column(String(50))
    densidade03 = Column(String(50))
    densidade04 = Column(String(50))
    densidade05 = Column(String(50))
    densidade06 = Column(String(50))
    densidade07 = Column(String(50))
    densidade08 = Column(String(50))
    densidade09 = Column(String(50))
    densidade10 = Column(String(50))
    fornecedor01 = Column(String(50))
    fornecedor02 = Column(String(50))
    fornecedor03 = Column(String(50))
    fornecedor04 = Column(String(50))
    fornecedor05 = Column(String(50))
    fornecedor06 = Column(String(50))
    fornecedor07 = Column(String(50))
    fornecedor08 = Column(String(50))
    fornecedor09 = Column(String(50))
    fornecedor10 = Column(String(50))






		











def create_tables():
    Base.metadata.create_all(engine)

def main():
    create_tables()
    print("Tabelas criadas com sucesso!")

if __name__ == "__main__":
    main()