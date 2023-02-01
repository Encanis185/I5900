import { StatusBar } from 'expo-status-bar';
import { SafeAreaView } from 'react-native-safe-area-context';
import { StyleSheet, Text, TouchableOpacity, View, Image, TextInput, Button, Alert} from 'react-native';
import { useState } from 'react';

const insertVisits = async (centerId, month, year, NA_visits, EX_visits) => {
    const url = 'https://projectatp.000webhostapp.com/SSPBD/InsertVisitasMes.php';
    const query = `?centerId=${centerId}&month=${month}&year=${year}&NA_visits=${NA_visits}&EX_visits=${EX_visits}`;

    const petition = await fetch(url + query);
    const response = await petition.text();

    if(response == '1'){
        Alert.alert('Operación  Exitosa', 'Visitas modificadas exitosamente...', [{text: 'Ok'}], {cancelable: true});
    }else if (response == '2'){
        Alert.alert('Operación  Exitosa', 'Visitas agregadas exitosamente...', [{text: 'Ok'}], {cancelable: true});
    } else {
        Alert.alert('Operación Fallida', 'Error al modificar/agregar visitas...', [{text: 'Ok'}], {cancelable: true});
    }
}


export default function AddCenterInfo({navigation}) {
    //Informacion del centro
    const [imageURL, setImageURL] = useState(null);
    const [centerName, setCenterName] = useState('Nombre del Centro');
    const [centerId, setCenterId] = useState(undefined); //este lo vamos a usar para modificar directamente en el scipt de php
    const [state, setState] = useState('Estado');
    const [municipality, setMunicipality] = useState('Municipio');
    const [centerType, setCenterType] = useState('Tipo de Centro');
    const [searchState, setSearchState] = useState(null);

    //Informacion de las visitas
    const [month, setMonth] = useState(null);
    const [year, setYear] = useState(null);
    const [NA_visits, setNA_visits] = useState(null);
    const [EX_visits, setEX_visits] = useState(null);

    const searchData = async (centerName) => {
        const url = 'https://projectatp.000webhostapp.com/SSPBD/SearchData.php';
        const query = `?centerName=${centerName}`;

        const petition = await fetch(url+query);
        const response = await petition.json();

        if(response){
            setCenterName(response[0].nombreCentro);
            setCenterId(response[0].idCentro);
            setImageURL(response[0].imagenURL);
            setState(response[0].nombreEstado);
            setMunicipality(response[0].nombreMunicipio);
            setCenterType(response[0].nombreTipoCentro);
        } else {
            Alert.alert('Centro', 'El centro que quiere buscar no existe...', [{text: 'Ok'}], {cancelable: true});
        }
    }

    return (
        <SafeAreaView style={styles.mainContainer}>
            <Text style={{fontSize: 20, fontWeight: '600', color: '#EFF3F5', marginBottom: 20}}>Añadir Informacion</Text>
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
                </View>
            </View>

            <View style={styles.inputsContainer}>
                <View style={styles.serachCiteContainer}>
                    <TextInput
                        style={[styles.inputsContainer_Input, {flex: 1}]}
                        placeholder='Nombre centro a buscar...'
                        placeholderTextColor={'#C8CDD0'}
                        onChangeText={(text) => {
                            (text)? setSearchState(text) : setSearchState(null);
                        }}
                    />
                    <TouchableOpacity
                        style={{backgroundColor: '#6C4AB6', padding: 5, borderRadius: 30, marginLeft: 10}}
                        onPress={() => {
                            if(!searchState){
                                Alert.alert('Datos Insuficientes', 'Ingresa el nombre del centro...', [{text: 'Ok'}], {cancelable: true});
                            } else {
                                searchData(searchState);
                            }
                        }}
                    >
                        <Image
                            style={{width: 30, height: 30}}
                            source={require('../assets/Icons/Search_icon.png')}
                        />
                    </TouchableOpacity>
                </View>

                <TextInput
                    style={styles.inputsContainer_Input}
                    placeholder='Mes...'
                    placeholderTextColor={'#C8CDD0'}
                    keyboardType='numeric'
                    onChangeText={(text) => {
                        (text)? setMonth(text) : setMonth(null);
                    }}
                />

                <TextInput
                    style={styles.inputsContainer_Input}
                    placeholder='Año...'
                    placeholderTextColor={'#C8CDD0'}
                    keyboardType='numeric'
                    onChangeText={(text) => {
                        (text)? setYear(text) : setYear(null);
                    }}
                />

                <TextInput
                    style={styles.inputsContainer_Input}
                    placeholder='Visitas Nacionales...'
                    placeholderTextColor={'#C8CDD0'}
                    keyboardType='numeric'
                    onChangeText={(text) => {
                        (text)? setNA_visits(text) : setNA_visits(null);
                    }}
                />

                <TextInput
                    style={styles.inputsContainer_Input}
                    placeholder='Visitas Extranjeras...'
                    placeholderTextColor={'#C8CDD0'}
                    keyboardType='numeric'
                    onChangeText={(text) => {
                        (text)? setEX_visits(text) : setEX_visits(null);
                    }}
                />

                <TouchableOpacity
                    style={{backgroundColor: '#6C4AB6', padding: 10, borderRadius: 30, marginTop: 10}}
                    onPress={() => {
                        if(!centerId || !month || !year || !NA_visits || !EX_visits){
                            Alert.alert('Datos Insuficientes', 'Ingresa todos los datos...', [{text: 'Ok'}], {cancelable: true});
                        } else {
                            insertVisits(centerId, month, year, NA_visits, EX_visits);
                        }
                    }}
                >
                    <Text style={{color: '#EFF3F5'}}>Añadir Informacion</Text>
                </TouchableOpacity>
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