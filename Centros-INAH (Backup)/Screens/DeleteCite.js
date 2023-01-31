import { StatusBar } from 'expo-status-bar';
import { SafeAreaView } from 'react-native-safe-area-context';
import { StyleSheet, Text, TouchableOpacity, View, Image, TextInput, Button, Alert} from 'react-native';
import { useState } from 'react';

async function deleteCenter(centerId) {
    const url = 'https://projectatp.000webhostapp.com/SSPBD/DeleteCentro.php';
    const query = `?centerId=${centerId}`;

    const petition = await fetch(url+query);
    const response = await petition.text();

    if(response == 1){
        Alert.alert('Exito', 'El centro ha sido eliminado exitosamente...', [{text: 'Ok'}], {cancelable: true});
    } else {
        Alert.alert('Error', 'El centro no se ha podido eliminar...', [{text: 'Ok'}], {cancelable: true});
    }
    
}

export default function DeleteCite({navigation}) {
    const [imageURL, setImageURL] = useState(null);
    const [centerName, setCenterName] = useState('Nombre del Centro');
    const [state, setState] = useState('Estado');
    const [municipality, setMunicipality] = useState('Municipio');
    const [centerType, setCenterType] = useState('Tipo de Centro');
    const [centerId, setCenterId] = useState(null)
    const [serachState, setSearchState] = useState(null);

    const searchData = async (centerName) => {
        const url = 'https://projectatp.000webhostapp.com/SSPBD/SearchData.php';
        const query = `?centerName=${centerName}`;
    
        const petition = await fetch(url+query);
        const response = await petition.json();

        console.log(response);
    
        if(response){
            setCenterName(response[0].nombreCentro);
            setImageURL(response[0].imagenURL);
            setState(response[0].nombreEstado);
            setMunicipality(response[0].nombreMunicipio);
            setCenterType(response[0].nombreTipoCentro);
            setCenterId(response[0].idCentro);
        } else {
            Alert.alert('Error en la busqueda', 'El centro que quiere buscar no existe...', [{text: 'Ok'}], {cancelable: true});
        }
    }

    return (
        <SafeAreaView style={styles.mainContainer}>
            <Text style={{fontSize: 20, fontWeight: '600', color: '#EFF3F5', marginBottom: 20}}>Eliminar Centro</Text>
            <View style={styles.cardContainer}>
                <View style={styles.cardImageContainer}>
                    <Image
                        style={styles.Image}
                        source={{uri: imageURL}}
                    />
                </View>
                <View style={styles.cardCiteInfo}>
                    <Text style={{fontSize: 22, fontWeight: '600', color:'#EFF3F5'}}>{centerName}</Text>
                    <Text style={{fontSize: 16, marginTop: 5, color: '#C8CDD0'}}>{state}, {municipality}</Text>
                    <Text style={{fontSize: 16, marginTop: 5, color: '#C8CDD0'}}>{centerType}</Text>
                    <TouchableOpacity
                        style={styles.cardInfoSubmit}
                        onPress={() => {
                            if(centerId){
                                deleteCenter(centerId);
                            } else {
                                Alert.alert('Error en la busqueda', 'Primero busca el centro para eliminar...', [{text: 'Ok'}], {cancelable: true});
                            }
                            
                        }}
                    >
                        <Image
                            style={{width: 30, height: 30}}
                            source={require('../assets/Icons/Delete_icon.png')}
                        />
                    </TouchableOpacity>
                </View>
            </View>

            <View style={styles.inputsContainer}>
                <View style={styles.serachCiteContainer}>
                    <TextInput
                        style={[styles.inputsContainer_Input, {flex: 1}]}
                        placeholder='Nombre sitio a eliminar...'
                        placeholderTextColor={'#C8CDD0'}
                        onChangeText={(text) => {
                            (text)? setSearchState(text) : setSearchState(null);
                        }}
                    />
                    <TouchableOpacity
                        style={{backgroundColor: '#6C4AB6', padding: 5, borderRadius: 30, marginLeft: 10}}
                        onPress={() => {
                            if(!serachState){
                                Alert.alert('Datos Insuficientes', 'Ingresa el nombre del centro...', [{text: 'Ok'}], {cancelable: true});
                            } else {
                                searchData(serachState);
                            }
                        }}
                    >
                        <Image
                            style={{width: 30, height: 30}}
                            source={require('../assets/Icons/Search_icon.png')}
                        />
                    </TouchableOpacity>
                </View>
            </View>
        </SafeAreaView>
    );
}

const styles = StyleSheet.create({
    mainContainer: {
        flex: 1,
        alignItems: 'center',
        justifyContent: 'center',
        backgroundColor: '#192229',
    },

    cardContainer: {
        display: 'flex',
        width: '90%',
        borderRadius: 16,
        backgroundColor: '#2A3B47',
        marginBottom: 30,
    },

    cardImageContainer: {
        width: '100%',
        height: 200,
        borderTopLeftRadius: 16,
        borderTopRightRadius: 16,
        overflow: 'hidden',
        backgroundColor: 'gray',
    },

    Image: {
        width: '100%',
        height: '100%',
        resizeMode: 'stretch',
    },

    serachCiteContainer: {
        width: '95%',
        display: 'flex',
        flexDirection: 'row',
        alignItems: 'center',
    },

    cardCiteInfo: {
        padding: 15
    },

    cardInfoSubmit: {
        width: 50,
        height: 50,
        justifyContent: 'center',
        alignItems: 'center',
        position: 'absolute',
        right: 30,
        top: '107%',
        backgroundColor: '#6C4AB6',
        borderRadius: 50,
    },

    inputsContainer: {
        width: '90%',
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: '#212E36',
        padding: 20,
        borderRadius: 16,
    },

    inputsContainer_Input: {
        width: '95%',
        color: '#C8CDD0',
        paddingVertical: 5,
        paddingHorizontal: 20,
        borderWidth: 1,
        borderColor: '#2A3B47',
        backgroundColor: '#2A3B47',
        borderRadius: 100,
        marginVertical: 10
    }
});